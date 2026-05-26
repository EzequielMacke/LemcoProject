<?php

namespace App\Http\Controllers;

use App\Mail\InformeMail;
use App\Models\Contacto;
use App\Models\DetalleInforme;
use App\Models\Usuario;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use App\Models\Obra;
use App\Models\Probeta;
use App\Models\ProbetaInforme;
use App\Models\Remision;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InformeController extends Controller
{
    public function index(Obra $obra): View
    {
        $informes = ProbetaInforme::where('obra_id', $obra->id)
            ->with(['recepcion', 'detalles.probeta'])
            ->withCount('detalles')
            ->orderByDesc('id')
            ->get();

        $probetasPendientes = Probeta::whereDoesntHave('detalles')
            ->where(fn($q) => $this->scopeEnsayada($q))
            ->whereHas('remision', fn($q) => $q->where('obra_id', $obra->id))
            ->with('remision')
            ->get();

        $pendientes = $probetasPendientes
            ->groupBy(function ($p) {
                $dias = ($p->fecha_moldeo && $p->fecha_ensayo)
                    ? $p->fecha_moldeo->diffInDays($p->fecha_ensayo)
                    : '';
                return $p->remision_id . '|' . ($p->fecha_moldeo?->format('Y-m-d') ?? '') . '|' . $dias;
            })
            ->map(function ($group) {
                $first = $group->first();
                return (object) [
                    'remision'     => $first->remision,
                    'fecha_moldeo' => $first->fecha_moldeo,
                    'dias_ensayo'  => ($first->fecha_moldeo && $first->fecha_ensayo)
                        ? $first->fecha_moldeo->diffInDays($first->fecha_ensayo)
                        : null,
                    'total'        => $group->count(),
                ];
            })
            ->sortBy(fn($p) => [
                $p->remision->nro ?? 0,
                $p->fecha_moldeo?->format('Y-m-d') ?? '',
                $p->dias_ensayo ?? 0,
            ])
            ->values();

        return view('informes.index', compact('obra', 'pendientes', 'informes'));
    }

    public function crear(Obra $obra, Remision $remision, Request $request): View
    {
        $fechaMoldeo = $request->query('fecha_moldeo');
        $diasEnsayo  = $request->has('dias_ensayo') ? (int) $request->query('dias_ensayo') : null;

        $probetas = Probeta::where('remision_id', $remision->id)
            ->whereDoesntHave('detalles')
            ->where(fn($q) => $this->scopeEnsayada($q))
            ->when($fechaMoldeo, fn($q) => $q->whereDate('fecha_moldeo', $fechaMoldeo))
            ->when($diasEnsayo !== null, fn($q) => $q->whereRaw('DATEDIFF(fecha_ensayo, fecha_moldeo) = ?', [$diasEnsayo]))
            ->orderBy('id')
            ->get();

        return view('informes.crear', compact('obra', 'remision', 'probetas', 'fechaMoldeo', 'diasEnsayo'));
    }

    public function store(Request $request, Obra $obra): RedirectResponse
    {
        $validated = $request->validate([
            'remision_id' => ['required', 'integer', 'exists:remisiones,id'],
            'probetas'    => ['required', 'array', 'min:1'],
            'probetas.*'  => ['integer', 'exists:probetas,id'],
        ]);

        $probetasValidas = Probeta::whereIn('id', $validated['probetas'])
            ->where('remision_id', $validated['remision_id'])
            ->whereDoesntHave('detalles')
            ->where(fn($q) => $this->scopeEnsayada($q))
            ->get();

        if ($probetasValidas->isEmpty()) {
            return back()->with('error', 'No hay probetas válidas seleccionadas.');
        }

        $informe = ProbetaInforme::create([
            'obra_id'      => $obra->id,
            'recepcion_id' => $validated['remision_id'],
        ]);

        foreach ($probetasValidas as $probeta) {
            DetalleInforme::create([
                'informe_id' => $informe->id,
                'probeta_id' => $probeta->id,
            ]);
        }

        return redirect()->route('informes.index', $obra)
            ->with('success', 'Informe generado correctamente.');
    }

    public function show(Obra $obra, ProbetaInforme $informe): View
    {
        $informe->load(['recepcion', 'detalles.probeta']);
        $usuarios  = Usuario::where('envio', 1)->with('persona')->get();
        $contactos = Contacto::where('obra_id', $obra->id)->where('estado', 1)->get();

        $nroInforme = ProbetaInforme::where('obra_id', $obra->id)
            ->where('id', '<=', $informe->id)
            ->count();

        return view('informes.details', compact('obra', 'informe', 'usuarios', 'contactos', 'nroInforme'));
    }

    public function enviar(Request $request, Obra $obra, ProbetaInforme $informe): RedirectResponse
    {
        $data = $request->validate([
            'usuarios'    => 'nullable|array',
            'usuarios.*'  => 'integer|exists:usuarios,id',
            'contactos'   => 'nullable|array',
            'contactos.*' => 'integer|exists:contactos,id',
        ]);

        if (empty($data['usuarios']) && empty($data['contactos'])) {
            return back()->with('error', 'Seleccioná al menos un destinatario.');
        }

        $informe->load(['recepcion', 'detalles.probeta']);

        $toBase64 = function (string $path): ?string {
            if (!file_exists($path)) return null;
            $mime = str_ends_with($path, '.jpg') || str_ends_with($path, '.jpeg') ? 'jpeg' : 'png';
            return "data:image/{$mime};base64," . base64_encode(file_get_contents($path));
        };

        $logo    = $toBase64(storage_path('app/private/logo/logo-web.png'));
        $tipo    = $toBase64(storage_path('app/private/tipo/tipo.jpg'));
        $firmash = $toBase64(storage_path('app/private/firmash/firmash.png'));

        $nroInforme = ProbetaInforme::where('obra_id', $obra->id)
            ->where('id', '<=', $informe->id)
            ->count();

        $pdfContent = Pdf::loadView('informes.pdf', compact('obra', 'informe', 'logo', 'tipo', 'firmash', 'nroInforme'))
            ->setPaper('a4', 'landscape')
            ->output();

        $primeraProbeta = $informe->detalles->first()?->probeta;
        $fechaEnsayo    = $primeraProbeta?->fecha_ensayo;
        $diasEnsayo     = ($primeraProbeta?->fecha_moldeo && $fechaEnsayo)
            ? $primeraProbeta->fecha_moldeo->diffInDays($fechaEnsayo)
            : null;

        $dia      = $fechaEnsayo?->day;
        $mes      = $fechaEnsayo?->locale('es')->monthName;
        $filename = "Obra {$obra->nombre} {$dia} de {$mes} {$diasEnsayo} dias.pdf";

        $destinatarios = collect();

        if (!empty($data['usuarios'])) {
            Usuario::whereIn('id', $data['usuarios'])->with('persona')->get()
                ->each(function ($u) use (&$destinatarios) {
                    if ($u->persona?->correo) $destinatarios->push($u->persona->correo);
                });
        }

        if (!empty($data['contactos'])) {
            Contacto::whereIn('id', $data['contactos'])->get()
                ->each(function ($c) use (&$destinatarios) {
                    if ($c->correo) $destinatarios->push($c->correo);
                });
        }

        $destinatarios = $destinatarios->unique();

        if ($destinatarios->isEmpty()) {
            return back()->with('error', 'Los destinatarios seleccionados no tienen correo registrado.');
        }

        foreach ($destinatarios as $correo) {
            Mail::to($correo)->send(new InformeMail($informe, $obra, $pdfContent, $filename));
        }

        $informe->update(['enviado' => 1]);

        return back()->with('success', "Informe enviado a {$destinatarios->count()} destinatario(s).");
    }

    public function pdf(Obra $obra, ProbetaInforme $informe): Response
    {
        $informe->load(['recepcion', 'detalles.probeta']);

        $toBase64 = function (string $path): ?string {
            if (!file_exists($path)) return null;
            $mime = str_ends_with($path, '.jpg') || str_ends_with($path, '.jpeg') ? 'jpeg' : 'png';
            return "data:image/{$mime};base64," . base64_encode(file_get_contents($path));
        };

        $logo    = $toBase64(storage_path('app/private/logo/logo-web.png'));
        $tipo    = $toBase64(storage_path('app/private/tipo/tipo.jpg'));
        $firmash = $toBase64(storage_path('app/private/firmash/firmash.png'));

        $nroInforme = ProbetaInforme::where('obra_id', $obra->id)
            ->where('id', '<=', $informe->id)
            ->count();

        $primeraProbeta = $informe->detalles->first()?->probeta;
        $fechaEnsayo    = $primeraProbeta?->fecha_ensayo;
        $diasEnsayo     = ($primeraProbeta?->fecha_moldeo && $fechaEnsayo)
            ? $primeraProbeta->fecha_moldeo->diffInDays($fechaEnsayo)
            : null;

        $pdf = Pdf::loadView('informes.pdf', compact('obra', 'informe', 'logo', 'tipo', 'firmash', 'nroInforme'))
            ->setPaper('a4', 'landscape');

        $fechaMoldeo = $primeraProbeta?->fecha_moldeo;
        $dia    = $fechaMoldeo?->day;
        $mes    = $fechaMoldeo?->locale('es')->monthName;
        $nombre = "Obra {$obra->nombre} {$dia} de {$mes} {$diasEnsayo} dias.pdf";

        return $pdf->download($nombre);
    }

    public function verificar(Obra $obra, ProbetaInforme $informe): RedirectResponse
    {
        $informe->update(['verificado' => 1]);

        return back()->with('success', 'Informe verificado correctamente.');
    }

    public function marcarPendiente(Obra $obra, ProbetaInforme $informe): RedirectResponse
    {
        $informe->update(['verificado' => 0]);

        return back()->with('success', 'Informe marcado como pendiente.');
    }

    public function destroy(Obra $obra, ProbetaInforme $informe): RedirectResponse
    {
        $informe->detalles()->delete();
        $informe->delete();

        return redirect()->route('informes.index', $obra)
            ->with('success', 'Informe eliminado correctamente.');
    }

    private function scopeEnsayada(Builder $q): void
    {
        $q->whereNotNull('fecha_ensayo')
          ->whereNotNull('ensayo_por')
          ->whereNotNull('defecto')
          ->whereNotNull('carga_rotura')
          ->whereNotNull('tipo_rotura')
          ->whereNotNull('diametro_superior_1')
          ->whereNotNull('diametro_superior_2')
          ->whereNotNull('diametro_inferior_1')
          ->whereNotNull('diametro_inferior_2')
          ->whereNotNull('altura_1')
          ->whereNotNull('altura_2')
          ->whereNotNull('altura_3');
    }
}
