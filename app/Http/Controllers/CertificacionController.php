<?php

namespace App\Http\Controllers;

use App\Mail\CertificadoMail;
use App\Models\Certificado;
use App\Models\CertificadoDetalle;
use App\Models\Contacto;
use App\Models\Obra;
use App\Models\ProbetaInforme;
use App\Models\Remision;
use App\Models\Usuario;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class CertificacionController extends Controller
{
    public function index(Obra $obra): View
    {
        $pendientes   = $this->pendientes($obra);
        $certificados = Certificado::where('obra_id', $obra->id)
            ->withCount('detalles')
            ->orderByDesc('id')
            ->get();

        // Mapa id → número correlativo de informe dentro de la obra (para tipoCert === 2)
        $nrosInformes = ProbetaInforme::where('obra_id', $obra->id)
            ->orderBy('id')
            ->pluck('id')
            ->values()
            ->mapWithKeys(fn($id, $idx) => [$id => $idx + 1]);

        // Mapa id → número correlativo de certificado dentro de la obra
        $nrosCertificados = Certificado::where('obra_id', $obra->id)
            ->orderBy('id')
            ->pluck('id')
            ->values()
            ->mapWithKeys(fn($id, $idx) => [$id => $idx + 1]);

        return view('certificacion.index', compact('obra', 'pendientes', 'certificados', 'nrosInformes', 'nrosCertificados'));
    }

    public function create(Obra $obra): View
    {
        $pendientes = $this->pendientes($obra);

        $nrosInformes = ProbetaInforme::where('obra_id', $obra->id)
            ->orderBy('id')
            ->pluck('id')
            ->values()
            ->mapWithKeys(fn($id, $idx) => [$id => $idx + 1]);

        $ultimoCertificado = Certificado::where('obra_id', $obra->id)
            ->orderByDesc('id')
            ->first();

        return view('certificacion.create', compact('obra', 'pendientes', 'nrosInformes', 'ultimoCertificado'));
    }

    public function store(Request $request, Obra $obra): RedirectResponse
    {
        $request->validate(
            [
                'precio_unitario' => 'required|numeric|min:0',
                'señores'         => 'required|string|max:255',
                'atte'            => 'required|string|max:255',
                'items'           => 'required|array|min:1',
                'items.*'         => 'required|integer',
            ],
            [
                'precio_unitario.required' => 'El precio unitario es obligatorio.',
                'precio_unitario.numeric'  => 'El precio unitario debe ser un número.',
                'señores.required'         => 'El campo Señores es obligatorio.',
                'atte.required'            => 'El campo Atte. es obligatorio.',
                'items.required'           => 'Debe incluir al menos un ítem en el certificado.',
                'items.min'                => 'Debe incluir al menos un ítem en el certificado.',
            ]
        );

        $certificado = Certificado::create([
            'obra_id'         => $obra->id,
            'precio_unitario' => $request->precio_unitario,
            'señores'         => $request->señores,
            'atte'            => $request->atte,
            'verificado'      => 0,
            'enviado'         => 0,
        ]);

        foreach ($request->items as $itemId) {
            CertificadoDetalle::create([
                'certificado_id' => $certificado->id,
                'remision_id'    => $obra->tipo_certificacion === 1 ? $itemId : null,
                'informe_id'     => $obra->tipo_certificacion === 2 ? $itemId : null,
            ]);
        }

        $nroCertificado = Certificado::where('obra_id', $obra->id)
            ->where('id', '<=', $certificado->id)
            ->count();

        return redirect()
            ->route('certificacion.index', $obra)
            ->with('success', 'Certificado #' . $nroCertificado . ' creado correctamente.');
    }

    public function edit(Obra $obra, Certificado $certificado): View
    {
        // IDs ya en este certificado
        $idsActuales = $certificado->detalles()->pluck(
            $obra->tipo_certificacion === 1 ? 'remision_id' : 'informe_id'
        )->filter()->values();

        // Ítems pendientes (no en ningún certificado)
        $nuevos = $this->pendientes($obra);

        // Ítems actuales del certificado
        if ($obra->tipo_certificacion === 1) {
            $actuales = Remision::whereIn('id', $idsActuales)
                ->withCount('probetas')
                ->orderBy('nro')
                ->get();
        } else {
            $actuales = ProbetaInforme::whereIn('id', $idsActuales)
                ->with('recepcion')
                ->withCount('detalles')
                ->orderByDesc('id')
                ->get();
        }

        // Combinamos: actuales primero, luego los nuevos pendientes
        $items = $actuales->merge($nuevos);

        $nrosInformes = ProbetaInforme::where('obra_id', $obra->id)
            ->orderBy('id')
            ->pluck('id')
            ->values()
            ->mapWithKeys(fn($id, $idx) => [$id => $idx + 1]);

        $nroCertificado = Certificado::where('obra_id', $obra->id)
            ->where('id', '<=', $certificado->id)
            ->count();

        return view('certificacion.edit', compact('obra', 'certificado', 'items', 'idsActuales', 'nrosInformes', 'nroCertificado'));
    }

    public function update(Request $request, Obra $obra, Certificado $certificado): RedirectResponse
    {
        if ($certificado->verificado) {
            return back()->with('error', 'No se puede editar un certificado ya verificado.');
        }

        $request->validate(
            [
                'precio_unitario' => 'required|numeric|min:0',
                'señores'         => 'required|string|max:255',
                'atte'            => 'required|string|max:255',
                'items'           => 'required|array|min:1',
                'items.*'         => 'required|integer',
            ],
            [
                'precio_unitario.required' => 'El precio unitario es obligatorio.',
                'precio_unitario.numeric'  => 'El precio unitario debe ser un número.',
                'señores.required'         => 'El campo Señores es obligatorio.',
                'atte.required'            => 'El campo Atte. es obligatorio.',
                'items.required'           => 'Debe incluir al menos un ítem en el certificado.',
                'items.min'                => 'Debe incluir al menos un ítem en el certificado.',
            ]
        );

        $certificado->update([
            'precio_unitario' => $request->precio_unitario,
            'señores'         => $request->señores,
            'atte'            => $request->atte,
        ]);

        // Reemplazamos los detalles
        $certificado->detalles()->delete();

        foreach ($request->items as $itemId) {
            CertificadoDetalle::create([
                'certificado_id' => $certificado->id,
                'remision_id'    => $obra->tipo_certificacion === 1 ? $itemId : null,
                'informe_id'     => $obra->tipo_certificacion === 2 ? $itemId : null,
            ]);
        }

        return redirect()
            ->route('certificacion.show', [$obra, $certificado])
            ->with('success', 'Certificado actualizado correctamente.');
    }

    public function pdf(Obra $obra, Certificado $certificado): Response
    {
        $certificado->load([
            'detalles.remision.probetas',
            'detalles.informe.detalles.probeta',
            'detalles.informe.recepcion',
        ]);

        $toBase64 = function (string $path): ?string {
            if (!file_exists($path)) return null;
            $ext  = strtolower(pathinfo($path, PATHINFO_EXTENSION));
            $mime = in_array($ext, ['jpg', 'jpeg']) ? 'jpeg' : 'png';
            return "data:image/{$mime};base64," . base64_encode(file_get_contents($path));
        };

        $logo    = $toBase64(storage_path('app/private/logo/logo-web.png'));
        $firmash = $toBase64(storage_path('app/private/firmash/firmash.png'));

        // Número de certificado dentro de la obra
        $nroCertificado = Certificado::where('obra_id', $obra->id)
            ->where('id', '<=', $certificado->id)
            ->count();

        // Totales
        $tipoCert      = $obra->tipo_certificacion;
        $totalProbetas = 0;
        foreach ($certificado->detalles as $d) {
            $totalProbetas += $tipoCert === 1
                ? ($d->remision?->probetas->count() ?? 0)
                : ($d->informe?->detalles->count() ?? 0);
        }
        $totalMonto = $totalProbetas * $certificado->precio_unitario;

        // Mapa id → número correlativo de informe dentro de la obra
        $nrosInformes = ProbetaInforme::where('obra_id', $obra->id)
            ->orderBy('id')
            ->pluck('id')
            ->values()
            ->mapWithKeys(fn($id, $idx) => [$id => $idx + 1]);

        $pdf = Pdf::loadView('certificacion.pdf', compact(
            'obra', 'certificado', 'logo', 'firmash',
            'nroCertificado', 'totalProbetas', 'totalMonto', 'tipoCert', 'nrosInformes'
        ))->setPaper('a4', 'portrait');

        $filename = "Certificado_{$nroCertificado}_{$obra->clave}.pdf";

        return response($pdf->output(), 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }

    public function enviar(Request $request, Obra $obra, Certificado $certificado): RedirectResponse
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

        $certificado->load([
            'detalles.remision.probetas',
            'detalles.informe.detalles.probeta',
            'detalles.informe.recepcion',
        ]);

        $toBase64 = function (string $path): ?string {
            if (!file_exists($path)) return null;
            $ext  = strtolower(pathinfo($path, PATHINFO_EXTENSION));
            $mime = in_array($ext, ['jpg', 'jpeg']) ? 'jpeg' : 'png';
            return "data:image/{$mime};base64," . base64_encode(file_get_contents($path));
        };

        $logo    = $toBase64(storage_path('app/private/logo/logo-web.png'));
        $firmash = $toBase64(storage_path('app/private/firmash/firmash.png'));

        $nroCertificado = Certificado::where('obra_id', $obra->id)
            ->where('id', '<=', $certificado->id)
            ->count();

        $tipoCert      = $obra->tipo_certificacion;
        $totalProbetas = 0;
        foreach ($certificado->detalles as $d) {
            $totalProbetas += $tipoCert === 1
                ? ($d->remision?->probetas->count() ?? 0)
                : ($d->informe?->detalles->count() ?? 0);
        }
        $totalMonto = $totalProbetas * $certificado->precio_unitario;

        $nrosInformes = ProbetaInforme::where('obra_id', $obra->id)
            ->orderBy('id')->pluck('id')->values()
            ->mapWithKeys(fn($id, $idx) => [$id => $idx + 1]);

        $pdfContent = Pdf::loadView('certificacion.pdf', compact(
            'obra', 'certificado', 'logo', 'firmash',
            'nroCertificado', 'totalProbetas', 'totalMonto', 'tipoCert', 'nrosInformes'
        ))->setPaper('a4', 'portrait')->output();

        $filename = "Certificado_{$nroCertificado}_{$obra->clave}.pdf";

        $destinatarios = collect();

        if (!empty($data['usuarios'])) {
            Usuario::whereIn('id', $data['usuarios'])->with('persona')->get()
                ->each(fn($u) => $u->persona?->correo && $destinatarios->push($u->persona->correo));
        }
        if (!empty($data['contactos'])) {
            Contacto::whereIn('id', $data['contactos'])->get()
                ->each(fn($c) => $c->correo && $destinatarios->push($c->correo));
        }

        $destinatarios = $destinatarios->unique();

        if ($destinatarios->isEmpty()) {
            return back()->with('error', 'Los destinatarios seleccionados no tienen correo registrado.');
        }

        foreach ($destinatarios as $correo) {
            Mail::to($correo)->send(new CertificadoMail($certificado, $obra, $nroCertificado, $pdfContent, $filename));
        }

        $certificado->update(['enviado' => 1]);

        return back()->with('success', "Certificado enviado a {$destinatarios->count()} destinatario(s).");
    }

    public function verificar(Obra $obra, Certificado $certificado): RedirectResponse
    {
        $certificado->update(['verificado' => 1]);

        $nroCertificado = Certificado::where('obra_id', $obra->id)
            ->where('id', '<=', $certificado->id)
            ->count();

        return back()->with('success', 'Certificado #' . $nroCertificado . ' marcado como verificado.');
    }

    public function desverificar(Obra $obra, Certificado $certificado): RedirectResponse
    {
        $certificado->update(['verificado' => 0]);

        $nroCertificado = Certificado::where('obra_id', $obra->id)
            ->where('id', '<=', $certificado->id)
            ->count();

        return back()->with('success', 'Certificado #' . $nroCertificado . ' marcado como pendiente de verificación.');
    }

    public function destroy(Obra $obra, Certificado $certificado): RedirectResponse
    {
        $nroCertificado = Certificado::where('obra_id', $obra->id)
            ->where('id', '<=', $certificado->id)
            ->count();

        $certificado->detalles()->delete();
        $certificado->delete();

        return back()->with('success', 'Certificado #' . $nroCertificado . ' eliminado correctamente.');
    }

    public function show(Obra $obra, Certificado $certificado): View
    {
        $certificado->load([
            'detalles.remision.probetas',
            'detalles.informe.detalles.probeta',
            'detalles.informe.recepcion',
        ]);

        $nrosInformes = ProbetaInforme::where('obra_id', $obra->id)
            ->orderBy('id')
            ->pluck('id')
            ->values()
            ->mapWithKeys(fn($id, $idx) => [$id => $idx + 1]);

        $nroCertificado = Certificado::where('obra_id', $obra->id)
            ->where('id', '<=', $certificado->id)
            ->count();

        $usuarios  = Usuario::where('envio', 1)->with('persona')->get();
        $contactos = Contacto::where('obra_id', $obra->id)->where('estado', 1)->get();

        return view('certificacion.show', compact('obra', 'certificado', 'nrosInformes', 'nroCertificado', 'usuarios', 'contactos'));
    }

    // ── Helpers ─────────────────────────────────────────────────────────────

    private function pendientes(Obra $obra)
    {
        $remisionesUsadas = CertificadoDetalle::whereNotNull('remision_id')
            ->whereHas('certificado', fn($q) => $q->where('obra_id', $obra->id))
            ->pluck('remision_id');

        $informesUsados = CertificadoDetalle::whereNotNull('informe_id')
            ->whereHas('certificado', fn($q) => $q->where('obra_id', $obra->id))
            ->pluck('informe_id');

        if ($obra->tipo_certificacion === 1) {
            return Remision::where('obra_id', $obra->id)
                ->whereNotIn('id', $remisionesUsadas)
                ->withCount('probetas')
                ->orderBy('nro')
                ->get();
        }

        return ProbetaInforme::where('obra_id', $obra->id)
            ->where('verificado', 1)
            ->whereNotIn('id', $informesUsados)
            ->with('recepcion')
            ->withCount('detalles')
            ->orderByDesc('id')
            ->get();
    }
}
