<?php

namespace App\Http\Controllers;

use App\Models\Certificado;
use App\Models\CertificadoDetalle;
use App\Models\Obra;
use App\Models\ProbetaInforme;
use App\Models\Probeta;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ObraExcelController extends Controller
{
    // ── Columnas (índice base-1) ──────────────────────────────────────────────

    // REMISIÓN  (A–C)
    private const C_NRO_REM   = 1;   // A
    private const C_FCH_REM   = 2;   // B
    private const C_CONTRAT   = 3;   // C

    // DATOS PROBETA  (D–L)
    private const C_CONCRET   = 4;   // D
    private const C_FCK       = 5;   // E
    private const C_ELEMENTO  = 6;   // F
    private const C_NOMBRE    = 7;   // G
    private const C_FCH_MOLD  = 8;   // H
    private const C_HORA_MOL  = 9;   // I
    private const C_MIXER     = 10;  // J
    private const C_EDAD      = 11;  // K
    private const C_SI_ENS    = 12;  // L  ← fórmula =H+K

    // ENSAYO  (M–Q)
    private const C_FCH_ENS   = 13;  // M
    private const C_DEFECTO   = 14;  // N
    private const C_CARGA     = 15;  // O
    private const C_TIPO_ROT  = 16;  // P
    private const C_ENS_POR   = 17;  // Q

    // MEDIDAS mm  (R–X)
    private const C_DS1       = 18;  // R
    private const C_DS2       = 19;  // S
    private const C_DI1       = 20;  // T
    private const C_DI2       = 21;  // U
    private const C_H1        = 22;  // V
    private const C_H2        = 23;  // W
    private const C_H3        = 24;  // X

    // CALCULADOS  (Y–AG)
    private const C_DPROM_SUP = 25;  // Y   ← fórmula
    private const C_DPROM_INF = 26;  // Z   ← fórmula
    private const C_DPROM     = 27;  // AA  ← fórmula
    private const C_AREA      = 28;  // AB  ← fórmula
    private const C_HPROM     = 29;  // AC  ← fórmula
    private const C_ESBELTEZ  = 30;  // AD  ← fórmula  λ = H/D
    private const C_RESIST    = 31;  // AE  ← fórmula  σ = F·1000/A
    private const C_FACTOR_HD = 32;  // AF  ← fórmula  C(h/d) IRAM 1550
    private const C_RESIST_COR= 33;  // AG  ← fórmula  σ corregida = σ × C(h/d)

    // INFORME  (AH–AI)
    private const C_NRO_INF   = 34;  // AH
    private const C_FCH_INF   = 35;  // AI

    // CERTIFICADO  (AJ–AK)
    private const C_NRO_CERT  = 36;  // AJ
    private const C_FCH_CERT  = 37;  // AK

    private const TOTAL_COLS  = 37;

    // ── Colores de cabecera ───────────────────────────────────────────────────
    private const BG_REMISION = 'FF1e3a5f';
    private const BG_DATOS    = 'FF0f4c75';
    private const BG_SI_ENS   = 'FFb45309';   // ámbar — columna destacada
    private const BG_ENSAYO   = 'FF064e3b';
    private const BG_MEDIDAS  = 'FF312e81';
    private const BG_CALC     = 'FF7c2d12';   // calculados
    private const BG_INFORME  = 'FF374151';
    private const BG_CERT     = 'FF4c1d95';

    private const TIPO_ROTURA = [
        1 => 'Tipo 1 – Cónica',
        2 => 'Tipo 2 – Cónica partida',
        3 => 'Tipo 3 – Cónica cizalla',
        4 => 'Tipo 4 – Cizalla',
        5 => 'Tipo 5 – Partida superior',
        6 => 'Tipo 6 – Similar col.',
    ];

    // ─────────────────────────────────────────────────────────────────────────
    public function exportar(Obra $obra)
    {
        // ── 1. Consultas ─────────────────────────────────────────────────────
        $probetas = Probeta::with([
            'remision',
            'ensayadoPor.persona',
            'detalles.informe',
        ])
        ->whereHas('remision', fn($q) => $q->where('obra_id', $obra->id))
        ->orderBy('remision_id')
        ->orderBy('fecha_moldeo')
        ->orderBy('id')
        ->get();

        // Nros correlativos de informes dentro de la obra
        $nrosInformes = ProbetaInforme::where('obra_id', $obra->id)
            ->orderBy('id')->pluck('id')->values()
            ->mapWithKeys(fn($id, $idx) => [$id => $idx + 1]);

        // Nros correlativos de certificados dentro de la obra
        $nrosCertificados = Certificado::where('obra_id', $obra->id)
            ->orderBy('id')->pluck('id')->values()
            ->mapWithKeys(fn($id, $idx) => [$id => $idx + 1]);

        // Certificados por remisión (tipo 1) o por informe (tipo 2)
        if ($obra->tipo_certificacion === 1) {
            $remisionIds  = $probetas->pluck('remision_id')->unique()->values();
            $certDetalles = CertificadoDetalle::with('certificado')
                ->whereNotNull('remision_id')
                ->whereIn('remision_id', $remisionIds)
                ->get()->keyBy('remision_id');
        } else {
            $informeIds   = $probetas
                ->flatMap(fn($p) => $p->detalles->pluck('informe_id'))
                ->unique()->values();
            $certDetalles = CertificadoDetalle::with('certificado')
                ->whereNotNull('informe_id')
                ->whereIn('informe_id', $informeIds)
                ->get()->keyBy('informe_id');
        }

        // ── 2. Spreadsheet ───────────────────────────────────────────────────
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()
            ->setTitle("Probetas – {$obra->nombre}")
            ->setCreator('LemcoProject');

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Probetas');

        $this->escribirCabeceras($sheet);

        $fila = 3;
        foreach ($probetas as $probeta) {
            $this->escribirFila(
                $sheet, $fila, $probeta,
                $nrosInformes, $nrosCertificados, $certDetalles, $obra
            );

            // Filas alternas con fondo muy sutil
            if ($fila % 2 === 0) {
                $rng = 'A' . $fila . ':' . Coordinate::stringFromColumnIndex(self::TOTAL_COLS) . $fila;
                $sheet->getStyle($rng)->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFF8FAFC');
            }
            $fila++;
        }

        // Ajuste automático de anchos
        for ($c = 1; $c <= self::TOTAL_COLS; $c++) {
            $sheet->getColumnDimension(Coordinate::stringFromColumnIndex($c))->setAutoSize(true);
        }
        // Anchos mínimos para textos largos
        foreach ([
            self::C_ELEMENTO => 22,
            self::C_NOMBRE   => 20,
            self::C_DEFECTO  => 22,
            self::C_ENS_POR  => 18,
            self::C_CONTRAT  => 20,
            self::C_TIPO_ROT => 24,
        ] as $c => $w) {
            $sheet->getColumnDimension(Coordinate::stringFromColumnIndex($c))->setWidth($w);
        }

        // Borde externo de la tabla
        if ($fila > 3) {
            $sheet->getStyle('A1:' . Coordinate::stringFromColumnIndex(self::TOTAL_COLS) . ($fila - 1))
                ->getBorders()->getOutline()
                ->setBorderStyle(Border::BORDER_MEDIUM)
                ->setColor(new Color('FF1e3a5f'));
        }

        $sheet->freezePane('A3');

        $sheet->getPageSetup()
            ->setOrientation(PageSetup::ORIENTATION_LANDSCAPE)
            ->setPaperSize(PageSetup::PAPERSIZE_A3)
            ->setFitToPage(true)
            ->setFitToWidth(1)
            ->setFitToHeight(0);
        $sheet->getPageMargins()->setTop(0.5)->setBottom(0.5)->setLeft(0.4)->setRight(0.4);

        // ── 3. Descarga ──────────────────────────────────────────────────────
        $nombreArchivo = 'Probetas ' . $obra->nombre . ' ' . now()->format('d-m-Y') . '.xlsx';
        $writer = new Xlsx($spreadsheet);

        return response()->streamDownload(
            fn() => $writer->save('php://output'),
            $nombreArchivo,
            ['Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']
        );
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  Cabeceras fila 1 (secciones) + fila 2 (columnas individuales)
    // ─────────────────────────────────────────────────────────────────────────
    private function escribirCabeceras($sheet): void
    {
        // Fila 1 — títulos de sección (celdas fusionadas)
        $secciones = [
            [self::C_NRO_REM,   self::C_CONTRAT,   'REMISIÓN',              self::BG_REMISION],
            [self::C_CONCRET,   self::C_EDAD,       'DATOS DE LA PROBETA',   self::BG_DATOS],
            [self::C_SI_ENS,    self::C_SI_ENS,     'SI ENSAYAR',            self::BG_SI_ENS],
            [self::C_FCH_ENS,   self::C_ENS_POR,    'ENSAYO DE COMPRESIÓN',  self::BG_ENSAYO],
            [self::C_DS1,       self::C_H3,         'MEDIDAS (mm)',          self::BG_MEDIDAS],
            [self::C_DPROM_SUP, self::C_RESIST_COR, 'CALCULADOS',            self::BG_CALC],
            [self::C_NRO_INF,   self::C_FCH_INF,    'INFORME',               self::BG_INFORME],
            [self::C_NRO_CERT,  self::C_FCH_CERT,   'CERTIFICADO',           self::BG_CERT],
        ];

        foreach ($secciones as [$cIni, $cFin, $titulo, $bg]) {
            $celIni = Coordinate::stringFromColumnIndex($cIni) . '1';
            $celFin = Coordinate::stringFromColumnIndex($cFin) . '1';

            if ($cIni !== $cFin) {
                $sheet->mergeCells("{$celIni}:{$celFin}");
            }

            $sheet->setCellValue($celIni, $titulo);
            $sheet->getStyle($celIni)->applyFromArray([
                'font'      => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF'], 'size' => 9],
                'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => $bg]],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF000000']]],
            ]);
        }

        $sheet->getRowDimension(1)->setRowHeight(22);

        // Fila 2 — nombres de cada columna
        $columnas = [
            self::C_NRO_REM   => ['Nº Rem.',         self::BG_REMISION],
            self::C_FCH_REM   => ['Fecha Rem.',       self::BG_REMISION],
            self::C_CONTRAT   => ['Contratista',      self::BG_REMISION],
            self::C_CONCRET   => ['Concretera',       self::BG_DATOS],
            self::C_FCK       => ['Fck (MPa)',         self::BG_DATOS],
            self::C_ELEMENTO  => ['Elemento',          self::BG_DATOS],
            self::C_NOMBRE    => ['Nombre',            self::BG_DATOS],
            self::C_FCH_MOLD  => ['Fecha Moldeo',      self::BG_DATOS],
            self::C_HORA_MOL  => ['Hora',              self::BG_DATOS],
            self::C_MIXER     => ['Mixer',             self::BG_DATOS],
            self::C_EDAD      => ['Edad (días)',       self::BG_DATOS],
            self::C_SI_ENS    => ['Si Ensayar',        self::BG_SI_ENS],
            self::C_FCH_ENS   => ['Fecha Ensayo',      self::BG_ENSAYO],
            self::C_DEFECTO   => ['Defecto',           self::BG_ENSAYO],
            self::C_CARGA     => ['Carga Rot. (kN)',   self::BG_ENSAYO],
            self::C_TIPO_ROT  => ['Tipo Rotura',       self::BG_ENSAYO],
            self::C_ENS_POR   => ['Ensayado Por',      self::BG_ENSAYO],
            self::C_DS1       => ['D.Sup.1 (mm)',      self::BG_MEDIDAS],
            self::C_DS2       => ['D.Sup.2 (mm)',      self::BG_MEDIDAS],
            self::C_DI1       => ['D.Inf.1 (mm)',      self::BG_MEDIDAS],
            self::C_DI2       => ['D.Inf.2 (mm)',      self::BG_MEDIDAS],
            self::C_H1        => ['Altura 1 (mm)',     self::BG_MEDIDAS],
            self::C_H2        => ['Altura 2 (mm)',     self::BG_MEDIDAS],
            self::C_H3        => ['Altura 3 (mm)',     self::BG_MEDIDAS],
            self::C_DPROM_SUP => ['D.Prom.Sup (mm)',   self::BG_CALC],
            self::C_DPROM_INF => ['D.Prom.Inf (mm)',   self::BG_CALC],
            self::C_DPROM     => ['D.Prom (mm)',       self::BG_CALC],
            self::C_AREA      => ['Área (mm²)',        self::BG_CALC],
            self::C_HPROM     => ['Alt.Prom (mm)',     self::BG_CALC],
            self::C_ESBELTEZ   => ['Esbeltez (h/d)',    self::BG_CALC],
            self::C_RESIST     => ['Resist. (MPa)',    self::BG_CALC],
            self::C_FACTOR_HD  => ['C(h/d)',           self::BG_CALC],
            self::C_RESIST_COR => ['Resist.Cor. (MPa)',self::BG_CALC],
            self::C_NRO_INF    => ['Nº Informe',       self::BG_INFORME],
            self::C_FCH_INF    => ['Fecha Inf.',       self::BG_INFORME],
            self::C_NRO_CERT   => ['Nº Certificado',   self::BG_CERT],
            self::C_FCH_CERT   => ['Fecha Cert.',      self::BG_CERT],
        ];

        foreach ($columnas as $c => [$label, $bg]) {
            $celda = Coordinate::stringFromColumnIndex($c) . '2';
            $sheet->setCellValue($celda, $label);
            $sheet->getStyle($celda)->applyFromArray([
                'font'      => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF'], 'size' => 8],
                'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => $bg]],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical'   => Alignment::VERTICAL_CENTER,
                    'wrapText'   => true,
                ],
                'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FF000000']]],
            ]);
        }

        $sheet->getRowDimension(2)->setRowHeight(30);
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  Escribir fila de datos
    // ─────────────────────────────────────────────────────────────────────────
    private function escribirFila(
        $sheet,
        int $r,
        Probeta $probeta,
        $nrosInformes,
        $nrosCertificados,
        $certDetalles,
        Obra $obra
    ): void {
        $rem = $probeta->remision;

        // Helper: convierte índice de columna a letra Excel
        $L = fn(int $c): string => Coordinate::stringFromColumnIndex($c);

        // ── Remisión ──────────────────────────────────────────────────────────
        $sheet->setCellValue([self::C_NRO_REM,  $r], $rem?->nro ?? '');
        $this->setFecha($sheet, self::C_FCH_REM, $r, $rem?->created_at);
        $sheet->setCellValue([self::C_CONTRAT,   $r], $rem?->contratista ?? '');

        // ── Datos de la probeta ───────────────────────────────────────────────
        $sheet->setCellValue([self::C_CONCRET,  $r], $probeta->concretera ?? '');
        $sheet->setCellValue([self::C_FCK,      $r], $probeta->fck);
        $sheet->setCellValue([self::C_ELEMENTO, $r], $probeta->elemento ?? '');
        $sheet->setCellValue([self::C_NOMBRE,   $r], $probeta->nombre ?? '');
        $this->setFecha($sheet, self::C_FCH_MOLD, $r, $probeta->fecha_moldeo);
        $sheet->setCellValue([self::C_HORA_MOL, $r], $probeta->hora_moldeo ?? '');
        $sheet->setCellValue([self::C_MIXER,    $r], $probeta->mixer ?? '');
        $sheet->setCellValue([self::C_EDAD,     $r], $probeta->edad_ensayo);

        // Si Ensayar: fórmula = FechaMoldeo + EdadEnsayo  →  fecha calculada de ensayo
        $cH = $L(self::C_FCH_MOLD);
        $cK = $L(self::C_EDAD);
        $sheet->setCellValue([self::C_SI_ENS, $r], "={$cH}{$r}+{$cK}{$r}");
        $sheet->getStyle([self::C_SI_ENS, $r])->getNumberFormat()->setFormatCode('DD/MM/YYYY');
        $sheet->getStyle([self::C_SI_ENS, $r])->getFill()
            ->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFF3CD');

        // ── Ensayo ────────────────────────────────────────────────────────────
        $this->setFecha($sheet, self::C_FCH_ENS, $r, $probeta->fecha_ensayo);
        $sheet->setCellValue([self::C_DEFECTO,  $r], $probeta->defecto ?? '');
        $sheet->setCellValue([self::C_CARGA,    $r], $probeta->carga_rotura !== null ? (float)$probeta->carga_rotura : '');
        $sheet->setCellValue([self::C_TIPO_ROT, $r], $probeta->tipo_rotura ? (self::TIPO_ROTURA[$probeta->tipo_rotura] ?? $probeta->tipo_rotura) : '');

        $ensayador = $probeta->ensayadoPor;
        $nombreEns = $ensayador
            ? (trim(($ensayador->persona?->nombre ?? '') . ' ' . ($ensayador->persona?->apellido ?? '')) ?: $ensayador->nick)
            : '';
        $sheet->setCellValue([self::C_ENS_POR, $r], $nombreEns);

        // ── Medidas ───────────────────────────────────────────────────────────
        $sheet->setCellValue([self::C_DS1, $r], $probeta->diametro_superior_1 !== null ? (float)$probeta->diametro_superior_1 : '');
        $sheet->setCellValue([self::C_DS2, $r], $probeta->diametro_superior_2 !== null ? (float)$probeta->diametro_superior_2 : '');
        $sheet->setCellValue([self::C_DI1, $r], $probeta->diametro_inferior_1 !== null ? (float)$probeta->diametro_inferior_1 : '');
        $sheet->setCellValue([self::C_DI2, $r], $probeta->diametro_inferior_2 !== null ? (float)$probeta->diametro_inferior_2 : '');
        $sheet->setCellValue([self::C_H1,  $r], $probeta->altura_1            !== null ? (float)$probeta->altura_1            : '');
        $sheet->setCellValue([self::C_H2,  $r], $probeta->altura_2            !== null ? (float)$probeta->altura_2            : '');
        $sheet->setCellValue([self::C_H3,  $r], $probeta->altura_3            !== null ? (float)$probeta->altura_3            : '');

        // ── Fórmulas calculadas ───────────────────────────────────────────────
        $cDS1 = $L(self::C_DS1);  $cDS2 = $L(self::C_DS2);
        $cDI1 = $L(self::C_DI1);  $cDI2 = $L(self::C_DI2);
        $cH1  = $L(self::C_H1);   $cH2  = $L(self::C_H2);  $cH3 = $L(self::C_H3);
        $cO   = $L(self::C_CARGA);
        $cY   = $L(self::C_DPROM_SUP);
        $cZ   = $L(self::C_DPROM_INF);
        $cAA  = $L(self::C_DPROM);
        $cAB  = $L(self::C_AREA);
        $cAC  = $L(self::C_HPROM);

        // Diámetro promedio superior  =(DS1+DS2)/2
        $sheet->setCellValue(
            [self::C_DPROM_SUP, $r],
            "=IF(OR({$cDS1}{$r}=\"\",{$cDS2}{$r}=\"\"),\"\",ROUND(({$cDS1}{$r}+{$cDS2}{$r})/2,2))"
        );

        // Diámetro promedio inferior  =(DI1+DI2)/2
        $sheet->setCellValue(
            [self::C_DPROM_INF, $r],
            "=IF(OR({$cDI1}{$r}=\"\",{$cDI2}{$r}=\"\"),\"\",ROUND(({$cDI1}{$r}+{$cDI2}{$r})/2,2))"
        );

        // Diámetro promedio total  =(DpSup+DpInf)/2
        $sheet->setCellValue(
            [self::C_DPROM, $r],
            "=IF(OR({$cY}{$r}=\"\",{$cZ}{$r}=\"\"),\"\",ROUND(({$cY}{$r}+{$cZ}{$r})/2,2))"
        );

        // Área mm²  =π×(D/2)²
        $sheet->setCellValue(
            [self::C_AREA, $r],
            "=IF({$cAA}{$r}=\"\",\"\",ROUND(PI()*({$cAA}{$r}/2)^2,2))"
        );

        // Altura promedio  =(H1+H2+H3)/3
        $sheet->setCellValue(
            [self::C_HPROM, $r],
            "=IF(OR({$cH1}{$r}=\"\",{$cH2}{$r}=\"\",{$cH3}{$r}=\"\"),\"\",ROUND(({$cH1}{$r}+{$cH2}{$r}+{$cH3}{$r})/3,2))"
        );

        // Esbeltez  λ=H/D
        $sheet->setCellValue(
            [self::C_ESBELTEZ, $r],
            "=IF(OR({$cAC}{$r}=\"\",{$cAA}{$r}=\"\"),\"\",ROUND({$cAC}{$r}/{$cAA}{$r},3))"
        );

        // Resistencia MPa  σ=F(kN)×1000/A(mm²)
        $sheet->setCellValue(
            [self::C_RESIST, $r],
            "=IF(OR({$cO}{$r}=\"\",{$cAB}{$r}=\"\"),\"\",ROUND({$cO}{$r}*1000/{$cAB}{$r},2))"
        );

        // ── C(h/d) — factor de corrección por esbeltez (IRAM 1550 / ASTM C39) ──
        // Interpolación lineal entre los puntos normalizados:
        //   h/d ≥ 2.00 → 1.000
        //   h/d = 1.75 → 0.980
        //   h/d = 1.50 → 0.960
        //   h/d = 1.25 → 0.930
        //   h/d = 1.00 → 0.870   (mínimo válido)
        $cAD  = $L(self::C_ESBELTEZ);
        $cAE  = $L(self::C_RESIST);
        $cAF  = $L(self::C_FACTOR_HD);
        $cAG  = $L(self::C_RESIST_COR);

        $fmtFactor =
            "=IF(OR({$cAD}{$r}=\"\",{$cAD}{$r}<1),\"\"," .
            "ROUND(" .
                "IF({$cAD}{$r}>=2,1," .
                    "IF({$cAD}{$r}>=1.75,0.98+({$cAD}{$r}-1.75)/0.25*0.02," .
                        "IF({$cAD}{$r}>=1.5,0.96+({$cAD}{$r}-1.5)/0.25*0.02," .
                            "IF({$cAD}{$r}>=1.25,0.93+({$cAD}{$r}-1.25)/0.25*0.03," .
                                "0.87+({$cAD}{$r}-1)/0.25*0.06" .
                            ")" .
                        ")" .
                    ")" .
                ")" .
            ",3))";

        $sheet->setCellValue([self::C_FACTOR_HD, $r], $fmtFactor);
        $sheet->getStyle([self::C_FACTOR_HD, $r])
            ->getNumberFormat()->setFormatCode('0.000');

        // Resistencia corregida  σc = σ × C(h/d)
        $sheet->setCellValue(
            [self::C_RESIST_COR, $r],
            "=IF(OR({$cAE}{$r}=\"\",{$cAF}{$r}=\"\"),\"\",ROUND({$cAE}{$r}*{$cAF}{$r},2))"
        );

        // Fondo tenue en zona calculada
        for ($c = self::C_DPROM_SUP; $c <= self::C_RESIST_COR; $c++) {
            $sheet->getStyle([$c, $r])->getFill()
                ->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFF8F0');
        }

        // ── Informe ───────────────────────────────────────────────────────────
        $detalle = $probeta->detalles->first();
        $informe = $detalle?->informe;

        if ($informe) {
            $sheet->setCellValue([self::C_NRO_INF, $r], $nrosInformes[$informe->id] ?? '');
            $this->setFecha($sheet, self::C_FCH_INF, $r, $informe->created_at);
        }

        // ── Certificado ───────────────────────────────────────────────────────
        $certDetalle = null;
        if ($obra->tipo_certificacion === 1) {
            $certDetalle = $certDetalles[$probeta->remision_id] ?? null;
        } elseif ($informe) {
            $certDetalle = $certDetalles[$informe->id] ?? null;
        }

        if ($certDetalle?->certificado) {
            $cert = $certDetalle->certificado;
            $sheet->setCellValue([self::C_NRO_CERT, $r], $nrosCertificados[$cert->id] ?? '');
            $this->setFecha($sheet, self::C_FCH_CERT, $r, $cert->created_at);
        }

        // ── Bordes de la fila ─────────────────────────────────────────────────
        $rng = 'A' . $r . ':' . Coordinate::stringFromColumnIndex(self::TOTAL_COLS) . $r;
        $sheet->getStyle($rng)->getBorders()->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN)
            ->setColor(new Color('FFD1D5DB'));

        // ── Alineación numérica a la derecha ──────────────────────────────────
        $colsNum = [
            self::C_NRO_REM, self::C_FCK,  self::C_EDAD,   self::C_CARGA,
            self::C_DS1,     self::C_DS2,  self::C_DI1,    self::C_DI2,
            self::C_H1,      self::C_H2,   self::C_H3,
            self::C_DPROM_SUP, self::C_DPROM_INF, self::C_DPROM,
            self::C_AREA,    self::C_HPROM,     self::C_ESBELTEZ,
            self::C_RESIST,  self::C_FACTOR_HD, self::C_RESIST_COR,
            self::C_NRO_INF, self::C_NRO_CERT,
        ];
        foreach ($colsNum as $c) {
            $sheet->getStyle([$c, $r])->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        }

        $sheet->getRowDimension($r)->setRowHeight(16);
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  Helper: escribe una fecha como serial Excel con formato DD/MM/YYYY
    // ─────────────────────────────────────────────────────────────────────────
    private function setFecha($sheet, int $col, int $row, $fecha): void
    {
        if ($fecha === null) {
            return;
        }

        $carbon = ($fecha instanceof \Carbon\Carbon)
            ? $fecha
            : \Carbon\Carbon::parse($fecha);

        // mktime con mediodía evita problemas de DST al convertir a serial Excel
        $serial = ExcelDate::PHPToExcel(
            mktime(12, 0, 0, $carbon->month, $carbon->day, $carbon->year)
        );

        $sheet->setCellValue([$col, $row], $serial);
        $sheet->getStyle([$col, $row])->getNumberFormat()->setFormatCode('DD/MM/YYYY');
    }
}
