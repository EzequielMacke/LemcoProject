<?php

namespace App\Http\Controllers;

use App\Models\Probeta;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BuscadorController extends Controller
{
    /** Reglas de validación por campo editable inline desde la tabla del buscador. */
    private const REGLAS_EDICION = [
        'nombre'              => ['required', 'string', 'max:255'],
        'mixer'               => ['required', 'string', 'max:255'],
        'concretera'          => ['required', 'string', 'max:255'],
        'fck'                 => ['required', 'integer', 'min:0'],
        'elemento'            => ['required', 'string', 'max:255'],
        'fecha_moldeo'        => ['required', 'date'],
        'hora_moldeo'         => ['required', 'date_format:H:i'],
        'edad_ensayo'         => ['required', 'integer', 'min:0'],
        'defecto'             => ['nullable', 'string', 'max:255'],
        'carga_rotura'        => ['nullable', 'numeric', 'min:0'],
        'tipo_rotura'         => ['nullable', 'integer', 'between:1,6'],
        'diametro_superior_1' => ['nullable', 'numeric', 'min:0'],
        'diametro_superior_2' => ['nullable', 'numeric', 'min:0'],
        'diametro_inferior_1' => ['nullable', 'numeric', 'min:0'],
        'diametro_inferior_2' => ['nullable', 'numeric', 'min:0'],
        'altura_1'            => ['nullable', 'numeric', 'min:0'],
        'altura_2'            => ['nullable', 'numeric', 'min:0'],
        'altura_3'            => ['nullable', 'numeric', 'min:0'],
    ];

    /** Campos de resultado de ensayo: quedan bloqueados una vez que la probeta entró en un informe. */
    private const CAMPOS_ENSAYO = [
        'defecto', 'carga_rotura', 'tipo_rotura',
        'diametro_superior_1', 'diametro_superior_2',
        'diametro_inferior_1', 'diametro_inferior_2',
        'altura_1', 'altura_2', 'altura_3',
    ];
    /** Columnas habilitadas para ordenar: clave de columna => expresión SQL (calificada o alias del SELECT). */
    private const SORTABLE = [
        'nombre'              => 'probetas.nombre',
        'obra'                => 'obras.nombre',
        'remision'            => 'remisiones.nro',
        'mixer'               => 'probetas.mixer',
        'concretera'          => 'probetas.concretera',
        'fck'                 => 'probetas.fck',
        'elemento'            => 'probetas.elemento',
        'fecha_moldeo'        => 'probetas.fecha_moldeo',
        'hora_moldeo'         => 'probetas.hora_moldeo',
        'edad_ensayo'         => 'probetas.edad_ensayo',
        'fecha_programada'    => 'fecha_programada',
        'defecto'             => 'probetas.defecto',
        'carga_rotura'        => 'probetas.carga_rotura',
        'tipo_rotura'         => 'probetas.tipo_rotura',
        'diametro_superior_1' => 'probetas.diametro_superior_1',
        'diametro_superior_2' => 'probetas.diametro_superior_2',
        'diametro_inferior_1' => 'probetas.diametro_inferior_1',
        'diametro_inferior_2' => 'probetas.diametro_inferior_2',
        'altura_1'            => 'probetas.altura_1',
        'altura_2'            => 'probetas.altura_2',
        'altura_3'            => 'probetas.altura_3',
        'ensayado_por'        => 'ensayado_por_nombre',
        'estado_ensayo'       => 'es_ensayada',
        'informe'             => 'informe_id',
        'certificado'         => 'certificado_id',
    ];

    /** Columnas habilitadas para filtrar desde la cabecera: clave => [columna real, tipo de filtro]. */
    private const FILTERS = [
        'nombre'              => ['col' => 'probetas.nombre',               'type' => 'text'],
        'obra'                => ['col' => 'obras.nombre',                  'type' => 'text'],
        'remision'            => ['col' => 'remisiones.nro',                'type' => 'text'],
        'mixer'               => ['col' => 'probetas.mixer',                'type' => 'text'],
        'concretera'          => ['col' => 'probetas.concretera',           'type' => 'text'],
        'fck'                 => ['col' => 'probetas.fck',                  'type' => 'text'],
        'elemento'            => ['col' => 'probetas.elemento',             'type' => 'text'],
        'fecha_moldeo'        => ['col' => 'probetas.fecha_moldeo',         'type' => 'date'],
        'hora_moldeo'         => ['col' => 'probetas.hora_moldeo',          'type' => 'text'],
        'edad_ensayo'         => ['col' => 'probetas.edad_ensayo',          'type' => 'text'],
        'fecha_programada'    => ['col' => 'fecha_programada',             'type' => 'date_having'],
        'defecto'             => ['col' => 'probetas.defecto',             'type' => 'text'],
        'carga_rotura'        => ['col' => 'probetas.carga_rotura',        'type' => 'text'],
        'tipo_rotura'         => ['col' => 'probetas.tipo_rotura',         'type' => 'exact'],
        'diametro_superior_1' => ['col' => 'probetas.diametro_superior_1', 'type' => 'text'],
        'diametro_superior_2' => ['col' => 'probetas.diametro_superior_2', 'type' => 'text'],
        'diametro_inferior_1' => ['col' => 'probetas.diametro_inferior_1', 'type' => 'text'],
        'diametro_inferior_2' => ['col' => 'probetas.diametro_inferior_2', 'type' => 'text'],
        'altura_1'            => ['col' => 'probetas.altura_1',           'type' => 'text'],
        'altura_2'            => ['col' => 'probetas.altura_2',           'type' => 'text'],
        'altura_3'            => ['col' => 'probetas.altura_3',           'type' => 'text'],
        'ensayado_por'        => ['col' => 'ensayado_por_nombre',         'type' => 'text_having'],
        // estado_ensayo, informe y certificado se resuelven aparte: son estados, no texto libre.
    ];

    /** Columnas con sugerencias (autocompletado): clave de filtro => atributo seleccionado en la fila. */
    private const SUGERENCIAS = [
        'nombre'              => 'nombre',
        'obra'                => 'obra_nombre',
        'remision'            => 'remision_nro',
        'mixer'               => 'mixer',
        'concretera'          => 'concretera',
        'fck'                 => 'fck',
        'elemento'            => 'elemento',
        'hora_moldeo'         => 'hora_moldeo',
        'edad_ensayo'         => 'edad_ensayo',
        'defecto'             => 'defecto',
        'carga_rotura'        => 'carga_rotura',
        'diametro_superior_1' => 'diametro_superior_1',
        'diametro_superior_2' => 'diametro_superior_2',
        'diametro_inferior_1' => 'diametro_inferior_1',
        'diametro_inferior_2' => 'diametro_inferior_2',
        'altura_1'            => 'altura_1',
        'altura_2'            => 'altura_2',
        'altura_3'            => 'altura_3',
        'ensayado_por'        => 'ensayado_por_nombre',
    ];

    public function index(Request $request): View
    {
        $clavesFiltro = array_merge(array_keys(self::FILTERS), ['estado_ensayo', 'informe', 'certificado']);
        $filtros = collect($clavesFiltro)
            ->mapWithKeys(fn ($key) => [$key => $request->query("f_{$key}")])
            ->filter(fn ($v) => $v !== null && $v !== '')
            ->all();

        $huboBusqueda = ! empty($filtros);

        $query = $this->baseQuery();
        $this->aplicarFiltros($query, $filtros);

        $orden = $this->parseOrden($request->query('sort'));
        foreach ($orden as $criterio) {
            $query->orderBy(self::SORTABLE[$criterio['key']], $criterio['dir']);
        }
        $query->orderBy('probetas.id', 'desc');

        $resultados = $query->limit(150)->get();

        $sortValue = implode(',', array_map(fn ($o) => "{$o['key']}:{$o['dir']}", $orden));
        $ordenPorClave = [];
        foreach ($orden as $i => $o) {
            $ordenPorClave[$o['key']] = ['dir' => $o['dir'], 'pos' => $i + 1];
        }

        $sugerencias = $this->sugerencias($filtros);

        return view('buscador.search', compact(
            'resultados', 'filtros', 'huboBusqueda', 'sortValue', 'ordenPorClave', 'sugerencias'
        ));
    }

    /** Query base: probetas + obra/remisión/ensayador + columnas calculadas (informe, certificado, estado). */
    private function baseQuery(): Builder
    {
        return Probeta::query()
            ->join('remisiones', 'probetas.remision_id', '=', 'remisiones.id')
            ->join('obras', 'remisiones.obra_id', '=', 'obras.id')
            ->leftJoin('usuarios as u_ensayo', 'probetas.ensayo_por', '=', 'u_ensayo.id')
            ->leftJoin('personas as p_ensayo', 'u_ensayo.persona_id', '=', 'p_ensayo.id')
            ->select('probetas.*')
            ->selectRaw('obras.id as obra_id')
            ->selectRaw('obras.nombre as obra_nombre')
            ->selectRaw('remisiones.nro as remision_nro')
            ->selectRaw('DATE_ADD(probetas.fecha_moldeo, INTERVAL probetas.edad_ensayo DAY) as fecha_programada')
            ->selectRaw("COALESCE(NULLIF(TRIM(CONCAT(COALESCE(p_ensayo.nombre,''), ' ', COALESCE(p_ensayo.apellido,''))), ''), u_ensayo.nick) as ensayado_por_nombre")
            ->selectRaw('(CASE WHEN probetas.fecha_ensayo IS NOT NULL AND probetas.ensayo_por IS NOT NULL
                    AND probetas.defecto IS NOT NULL AND probetas.carga_rotura IS NOT NULL AND probetas.tipo_rotura IS NOT NULL
                    AND probetas.diametro_superior_1 IS NOT NULL AND probetas.diametro_superior_2 IS NOT NULL
                    AND probetas.diametro_inferior_1 IS NOT NULL AND probetas.diametro_inferior_2 IS NOT NULL
                    AND probetas.altura_1 IS NOT NULL AND probetas.altura_2 IS NOT NULL AND probetas.altura_3 IS NOT NULL
                    THEN 1 ELSE 0 END) as es_ensayada')
            ->selectRaw('(SELECT di.informe_id FROM detalle_informes di WHERE di.probeta_id = probetas.id LIMIT 1) as informe_id')
            ->selectRaw('COALESCE(
                    (SELECT cd.certificado_id FROM certificado_detalles cd WHERE cd.remision_id = probetas.remision_id LIMIT 1),
                    (SELECT cd2.certificado_id FROM detalle_informes di2
                        JOIN certificado_detalles cd2 ON cd2.informe_id = di2.informe_id
                        WHERE di2.probeta_id = probetas.id LIMIT 1)
                ) as certificado_id');
    }

    /** Aplica los filtros activos a la query, opcionalmente salteando uno (para calcular sus propias sugerencias). */
    private function aplicarFiltros(Builder $query, array $filtros, ?string $excluir = null): void
    {
        foreach (self::FILTERS as $key => $cfg) {
            if ($key === $excluir) {
                continue;
            }

            $valor = $filtros[$key] ?? null;
            if ($valor === null) {
                continue;
            }

            match ($cfg['type']) {
                'text'        => $query->whereRaw("CAST({$cfg['col']} AS CHAR) LIKE ?", ["%{$valor}%"]),
                'exact'       => $query->where($cfg['col'], $valor),
                'date'        => $query->whereDate($cfg['col'], $valor),
                'date_having' => $query->having($cfg['col'], '=', $valor),
                'text_having' => $query->havingRaw("{$cfg['col']} LIKE ?", ["%{$valor}%"]),
            };
        }

        if ($excluir !== 'estado_ensayo') {
            match ($filtros['estado_ensayo'] ?? null) {
                'ensayada'  => $query->having('es_ensayada', '=', 1),
                'pendiente' => $query->having('es_ensayada', '=', 0),
                default     => null,
            };
        }

        if ($excluir !== 'informe') {
            match ($filtros['informe'] ?? null) {
                'con_informe' => $query->havingNotNull('informe_id'),
                'sin_informe' => $query->havingNull('informe_id'),
                default       => null,
            };
        }

        if ($excluir !== 'certificado') {
            match ($filtros['certificado'] ?? null) {
                'certificada'    => $query->havingNotNull('certificado_id'),
                'no_certificada' => $query->havingNull('certificado_id'),
                default          => null,
            };
        }
    }

    /**
     * Sugerencias por columna, acotadas al resto de los filtros activos: si ya se eligió una obra,
     * las sugerencias de remisión (y las demás) sólo muestran valores que existen dentro de esa obra.
     */
    private function sugerencias(array $filtros): array
    {
        $sugerencias = [];

        foreach (self::SUGERENCIAS as $clave => $atributo) {
            $query = $this->baseQuery();
            $this->aplicarFiltros($query, $filtros, excluir: $clave);

            $valores = $query->limit(600)->get()->pluck($atributo)
                ->filter(fn ($v) => $v !== null && $v !== '')
                ->map(fn ($v) => $atributo === 'hora_moldeo' ? substr((string) $v, 0, 5) : (string) $v)
                ->unique()
                ->sort()
                ->take(50)
                ->values()
                ->all();

            $sugerencias[$clave] = $valores;
        }

        return $sugerencias;
    }

    /** Edición inline de un campo propio de la probeta desde la fila del buscador. */
    public function update(Request $request, Probeta $probeta): JsonResponse
    {
        $campo = $request->input('campo');

        if (! is_string($campo) || ! array_key_exists($campo, self::REGLAS_EDICION)) {
            return response()->json(['message' => 'Campo no editable.'], 422);
        }

        $esCampoEnsayo = in_array($campo, self::CAMPOS_ENSAYO, true);

        if ($esCampoEnsayo && $probeta->detalles()->exists()) {
            return response()->json(['message' => 'La probeta ya pertenece a un informe y no se puede editar.'], 403);
        }

        $validado = $request->validate(['valor' => self::REGLAS_EDICION[$campo]]);

        $probeta->{$campo} = $validado['valor'];

        if ($esCampoEnsayo) {
            $completa = collect(self::CAMPOS_ENSAYO)->every(fn ($c) => $probeta->{$c} !== null);

            if ($completa) {
                if ($probeta->fecha_ensayo === null) {
                    $probeta->fecha_ensayo = now()->toDateString();
                    $probeta->ensayo_por   = session('usuario.id');
                }
            } else {
                $probeta->fecha_ensayo = null;
                $probeta->ensayo_por   = null;
            }
        }

        $probeta->save();

        return response()->json([
            'ok'               => true,
            'valor'            => $this->formatearValor($campo, $probeta->{$campo}),
            'fecha_programada' => $probeta->fecha_moldeo->copy()->addDays($probeta->edad_ensayo)->format('d/m/Y'),
            'es_ensayada'      => $this->estaEnsayada($probeta),
        ]);
    }

    /** Formatea el valor guardado tal como se muestra en la celda de la tabla. */
    private function formatearValor(string $campo, mixed $valor): string
    {
        if ($valor === null || $valor === '') {
            return '—';
        }

        return match ($campo) {
            'fecha_moldeo' => $valor->format('d/m/Y'),
            'hora_moldeo'  => substr((string) $valor, 0, 5),
            'edad_ensayo'  => $valor.' días',
            'carga_rotura', 'diametro_superior_1', 'diametro_superior_2',
            'diametro_inferior_1', 'diametro_inferior_2',
            'altura_1', 'altura_2', 'altura_3' => number_format((float) $valor, 2),
            default => (string) $valor,
        };
    }

    /** Réplica de la condición de "ensayada" usada en el listado (ver es_ensayada en baseQuery). */
    private function estaEnsayada(Probeta $probeta): bool
    {
        return $probeta->fecha_ensayo        !== null
            && $probeta->ensayo_por          !== null
            && $probeta->defecto             !== null
            && $probeta->carga_rotura        !== null
            && $probeta->tipo_rotura         !== null
            && $probeta->diametro_superior_1 !== null
            && $probeta->diametro_superior_2 !== null
            && $probeta->diametro_inferior_1 !== null
            && $probeta->diametro_inferior_2 !== null
            && $probeta->altura_1            !== null
            && $probeta->altura_2            !== null
            && $probeta->altura_3            !== null;
    }

    /** @return array<int, array{key: string, dir: string}> */
    private function parseOrden(?string $sort): array
    {
        if (! $sort) {
            return [];
        }

        $orden = [];
        foreach (explode(',', $sort) as $parte) {
            [$clave, $dir] = array_pad(explode(':', $parte), 2, 'asc');
            if (isset(self::SORTABLE[$clave])) {
                $orden[] = ['key' => $clave, 'dir' => strtolower($dir) === 'desc' ? 'desc' : 'asc'];
            }
        }

        return $orden;
    }
}
