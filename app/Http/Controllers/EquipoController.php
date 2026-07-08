<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\DetalleRetiro;
use App\Models\Equipo;
use App\Models\Marca;
use App\Models\TipoEquipo;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class EquipoController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $idNoIdentificable = TipoEquipo::where('descripcion', 'No identificable')->value('id');
        $this->validarDatos($request, $idNoIdentificable);

        $permiteCantidad = (int) $request->tipo_equipo_id === (int) $idNoIdentificable;

        $marca = $request->filled('marca')
            ? Marca::firstOrCreate(['descripcion' => trim($request->marca)])
            : null;
        $categoria = $request->filled('categoria')
            ? Categoria::firstOrCreate(['descripcion' => trim($request->categoria)])
            : null;

        $nombre = trim($request->nombre);
        $abreviacion = $this->generarAbreviacion();

        do {
            $codigoQr = strtoupper(Str::random(10));
        } while (Equipo::where('codigo_qr', $codigoQr)->exists());

        $equipo = Equipo::create([
            'nombre'         => $nombre,
            'abreviacion'    => $abreviacion,
            'marca_id'       => $marca?->id,
            'modelo'         => $request->modelo,
            'numero_serie'   => $request->numero_serie,
            'observacion'    => $request->observacion,
            'estado'         => 1,
            'categoria_id'   => $categoria?->id,
            'tipo_equipo_id' => $request->tipo_equipo_id,
            'codigo_qr'      => $codigoQr,
            'usuario_id'     => session('usuario.id'),
        ]);

        $equipo->inventarios()->create([
            'cantidad' => $permiteCantidad ? (int) $request->cantidad : 1,
        ]);

        return back()->with('success', 'Equipo creado correctamente.');
    }

    public function update(Request $request, Equipo $equipo): RedirectResponse
    {
        $idNoIdentificable = TipoEquipo::where('descripcion', 'No identificable')->value('id');
        $this->validarDatos($request, $idNoIdentificable);

        $permiteCantidad = (int) $request->tipo_equipo_id === (int) $idNoIdentificable;

        $marca = $request->filled('marca')
            ? Marca::firstOrCreate(['descripcion' => trim($request->marca)])
            : null;
        $categoria = $request->filled('categoria')
            ? Categoria::firstOrCreate(['descripcion' => trim($request->categoria)])
            : null;

        $equipo->update([
            'nombre'         => trim($request->nombre),
            'marca_id'       => $marca?->id,
            'modelo'         => $request->modelo,
            'numero_serie'   => $request->numero_serie,
            'observacion'    => $request->observacion,
            'categoria_id'   => $categoria?->id,
            'tipo_equipo_id' => $request->tipo_equipo_id,
        ]);

        $equipo->inventarios()->firstOrCreate([])->update([
            'cantidad' => $permiteCantidad ? (int) $request->cantidad : 1,
        ]);

        return back()->with('success', 'Equipo actualizado correctamente.');
    }

    public function eliminar(Equipo $equipo): RedirectResponse
    {
        $equipo->update(['estado' => 2]);

        return back()->with('success', 'Equipo eliminado correctamente.');
    }

    public function buscarPorQr(string $codigo): JsonResponse
    {
        $equipo = Equipo::with(['marca', 'categoria', 'tipoEquipo'])
            ->where('codigo_qr', $codigo)
            ->where('estado', 1)
            ->first();

        if (! $equipo) {
            return response()->json(['message' => 'No se encontró ningún equipo activo con ese código QR.'], 404);
        }

        $ultimoDetalle = DetalleRetiro::where('equipo_id', $equipo->id)
            ->with(['retiro.obraRetiro', 'retiro.funcionarioRetiro'])
            ->latest('id')
            ->first();

        $retiroPendiente = null;
        if ($ultimoDetalle && is_null($ultimoDetalle->fecha_devolucion)) {
            $retiroPendiente = [
                'detalle_retiro_id' => $ultimoDetalle->id,
                'obra'              => $ultimoDetalle->retiro?->obraRetiro?->descripcion,
                'retirado_por'      => $ultimoDetalle->retiro?->funcionarioRetiro?->descripcion,
                'fecha_retiro'      => optional($ultimoDetalle->fecha_retiro)->format('d/m/Y'),
            ];
        }

        return response()->json([
            'id'               => $equipo->id,
            'nombre'           => $equipo->nombre,
            'abreviacion'      => $equipo->abreviacion,
            'marca'            => $equipo->marca->descripcion ?? null,
            'modelo'           => $equipo->modelo,
            'numero_serie'     => $equipo->numero_serie,
            'categoria'        => $equipo->categoria->descripcion ?? null,
            'tipo_equipo'      => $equipo->tipoEquipo->descripcion ?? null,
            'observacion'      => $equipo->observacion,
            'codigo_qr'        => $equipo->codigo_qr,
            'retiro_pendiente' => $retiroPendiente,
        ]);
    }

    public function qr(Equipo $equipo): Response
    {
        $contenido = $this->generarImagenQr($equipo);
        $nombreArchivo = ($equipo->abreviacion ?: 'equipo') . '.png';

        return response($contenido, 200, [
            'Content-Type'        => 'image/png',
            'Content-Disposition' => 'attachment; filename="' . $nombreArchivo . '"',
        ]);
    }

    public function qrTodos(): BinaryFileResponse
    {
        $equipos = Equipo::where('estado', 1)->orderBy('id')->get();

        $tmpFile = tempnam(sys_get_temp_dir(), 'lemco_qr_');
        $zip = new \ZipArchive();
        $zip->open($tmpFile, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        $nombresUsados = [];
        foreach ($equipos as $equipo) {
            $nombreArchivo = ($equipo->abreviacion ?: 'equipo-' . $equipo->id) . '.png';
            if (isset($nombresUsados[$nombreArchivo])) {
                $nombresUsados[$nombreArchivo]++;
                $nombreArchivo = pathinfo($nombreArchivo, PATHINFO_FILENAME) . '-' . $nombresUsados[$nombreArchivo] . '.png';
            } else {
                $nombresUsados[$nombreArchivo] = 1;
            }

            $zip->addFromString($nombreArchivo, $this->generarImagenQr($equipo));
        }

        $zip->close();

        return response()->download($tmpFile, 'QR Equipos.zip', [
            'Content-Type' => 'application/zip',
        ])->deleteFileAfterSend(true);
    }

    private function generarImagenQr(Equipo $equipo): string
    {
        // Lienzo de 5cm x 5cm a 300dpi (1cm ≈ 118.11px)
        $canvasSize = 591;
        $qrSize = 430;
        $qrY = 30;

        $qrResult = (new PngWriter())->write(
            new QrCode(data: (string) $equipo->codigo_qr, size: $qrSize, margin: 10)
        );

        $qrImage = imagecreatefromstring($qrResult->getString());

        $canvas = imagecreatetruecolor($canvasSize, $canvasSize);
        $blanco = imagecolorallocate($canvas, 255, 255, 255);
        imagefill($canvas, 0, 0, $blanco);

        $qrX = intdiv($canvasSize - $qrSize, 2);
        imagecopy($canvas, $qrImage, $qrX, $qrY, 0, 0, $qrSize, $qrSize);
        imagedestroy($qrImage);

        $negro = imagecolorallocate($canvas, 0, 0, 0);
        $fontPath = base_path('vendor/endroid/qr-code/assets/open_sans.ttf');
        $fontSize = 26;
        $texto = (string) $equipo->abreviacion;

        $bbox = imagettfbbox($fontSize, 0, $fontPath, $texto);
        $textoAncho = abs($bbox[4] - $bbox[0]);
        $textoAlto = abs($bbox[5] - $bbox[1]);
        $espacioInferior = $canvasSize - ($qrY + $qrSize);
        $textoX = intdiv($canvasSize - $textoAncho, 2);
        $textoY = $qrY + $qrSize + intdiv($espacioInferior + $textoAlto, 2);

        imagettftext($canvas, $fontSize, 0, $textoX, $textoY, $negro, $fontPath, $texto);

        $margenBorde = 12;
        imagesetthickness($canvas, 4);
        imagerectangle($canvas, $margenBorde, $margenBorde, $canvasSize - 1 - $margenBorde, $canvasSize - 1 - $margenBorde, $negro);

        ob_start();
        imagepng($canvas);
        $contenido = ob_get_clean();
        imagedestroy($canvas);

        return $contenido;
    }

    private function generarAbreviacion(): string
    {
        $correlativo = Equipo::count() + 1;

        return 'EQU-' . str_pad($correlativo, 3, '0', STR_PAD_LEFT);
    }

    private function validarDatos(Request $request, ?int $idNoIdentificable): void
    {
        $request->validate([
            'nombre'         => 'required|string|max:150',
            'marca'          => 'nullable|string|max:100',
            'modelo'         => 'nullable|string|max:100',
            'numero_serie'   => 'nullable|string|max:100',
            'tipo_equipo_id' => 'required|exists:tipo_equipos,id',
            'categoria'      => 'nullable|string|max:100',
            'cantidad'       => 'required_if:tipo_equipo_id,' . $idNoIdentificable . '|nullable|integer|min:1',
            'observacion'    => 'nullable|string|max:255',
        ], [
            'nombre.required'         => 'El nombre es obligatorio.',
            'tipo_equipo_id.required' => 'El tipo de equipo es obligatorio.',
            'tipo_equipo_id.exists'   => 'El tipo de equipo seleccionado no es válido.',
            'cantidad.required_if'    => 'La cantidad es obligatoria para este tipo de equipo.',
            'cantidad.integer'        => 'La cantidad debe ser un número entero.',
            'cantidad.min'            => 'La cantidad debe ser al menos 1.',
        ]);
    }
}
