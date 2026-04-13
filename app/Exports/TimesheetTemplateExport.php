<?php

namespace App\Exports;

use App\Models\TransaksiSewa;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Symfony\Component\HttpFoundation\StreamedResponse;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Carbon\Carbon;


class TimesheetTemplateExport
{
    public function export($transaksiId)
    {
        // Load template
        $spreadsheet = IOFactory::load(
            storage_path('app/templates/timesheet_template.xlsx')
        );
        $sheet = $spreadsheet->getActiveSheet();

        // Ambil data transaksi
        $t = TransaksiSewa::with([
            'pelanggan',
            'operator',
            'timesheets',
            'hmLogs',
            'dpPembayaran' => function($q) {
                $q->orderBy('tanggal', 'asc');
            }
        ])->findOrFail($transaksiId);


        $hargaBaket = $t->harga_sewa_baket ?? 0;
        $hargaBreker = $t->harga_sewa_breker ?? 0;

                // =============================
        // PATCH: NORMALIZE JENIS PEKERJAAN (JSON / STRING)
        // =============================
        $jenisPekerjaan = $t->jenis_pekerjaan;

        if (is_string($jenisPekerjaan)) {
            $decoded = json_decode($jenisPekerjaan, true);
            $jenisPekerjaan = is_array($decoded) ? $decoded : [$jenisPekerjaan];
        }

        $jenisPekerjaan = array_map('strtolower', $jenisPekerjaan);

        // =============================
        // HEADER
        // =============================
        $sheet->setCellValue('G9',  $t->pelanggan->nama ?? '-');
        $sheet->setCellValue('G10', $t->operator->nama ?? '-');
        // Kita format dulu masing-masing tanggalnya
        $tglMulai = $t->tanggal_mulai ? Carbon::parse($t->tanggal_mulai)->format('d/m/Y') : '-';
        $tglSelesai = $t->tanggal_selesai ? Carbon::parse($t->tanggal_selesai)->format('d/m/Y') : '-';

        // Baru kita gabungin di cell G11
        $sheet->setCellValue('G11', $tglMulai . ' - ' . $tglSelesai);
        $sheet->setCellValue('G12',  $t->jenis_sewa ?? '-');
        $sheet->setCellValue('D19', 'Operator ' . $t->operator->nama ?? '-');
        $hmTerbaru = $t->timesheets?->sortByDesc('created_at')->first();    
        $sheet->setCellValue('G30', $hmTerbaru->hm_awal ?? '-');
        $sheet->setCellValue('G33', $hmTerbaru->hm_akhir ?? '-');
        $tglAwal = $hmTerbaru->tanggal_awal_hm ? Carbon::parse($hmTerbaru->tanggal_awal_hm)->format('d/m/Y') : '-';
        $tglAkhir = $hmTerbaru->tanggal_akhir_hm ? Carbon::parse($hmTerbaru->tanggal_akhir_hm)->format('d/m/Y') : '-';
        $sheet->setCellValue('C30', $tglAwal);
        $sheet->setCellValue('C33', $tglAkhir);
        $sheet->getStyle('C30:C33')->getNumberFormat()->setFormatCode('dd/mm/yyyy');
        $sheet->setCellValue('G16', $t->mobilisasi . ' - ' . $t->demobilisasi ?? '-');
        $sheet->mergeCells("AM16:AN16");
        $sheet->setCellValue('AM16', $t->biaya_modem ?? '0');
        // $sheet->setCellValue('AB29', implode(', ', $jenisPekerjaan));

        $jenis = $jenisPekerjaan; // sudah dinormalisasi

        $adaBaket  = in_array('baket', $jenis);
        $adaBreker = in_array('breker', $jenis);

        $row = 29;

        /**
         * =========================
         * BAKET + BREKER
         * =========================
         */
        if ($adaBaket && $adaBreker) {

            // ===== BAKET =====
            $sheet->setCellValue("AB{$row}", "Baket");
            $sheet->setCellValueExplicit(
                "AD{$row}",
                (int) $hargaBaket,
                DataType::TYPE_NUMERIC
            );

            $sheet->getStyle("AD{$row}")
                ->getNumberFormat()
                ->setFormatCode('#,##0_);(#,##0)');

            $sheet->getStyle("AD{$row}")
                ->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_RIGHT);

            // Copy style ke baris bawah
            $sheet->duplicateStyle(
                $sheet->getStyle("AB{$row}:AG{$row}"),
                "AB" . ($row + 1) . ":AG" . ($row + 1)
            );

            $sheet->mergeCells("AB" . ($row + 1) . ":AC" . ($row + 1));
            $sheet->mergeCells("AD" . ($row + 1) . ":AG" . ($row + 1));

            // ===== BREKER =====
            $sheet->setCellValue("AB" . ($row + 1), "Breker");
            $sheet->setCellValueExplicit(
                "AD" . ($row + 1),
                (int) $hargaBreker,
                DataType::TYPE_NUMERIC
            );

            $sheet->getStyle("AD" . ($row + 1))
                ->getNumberFormat()
                ->setFormatCode('#,##0_);(#,##0)');

            $sheet->getStyle("AD" . ($row + 1))
                ->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        }

        /**
         * =========================
         * BAKET SAJA
         * =========================
         */
        elseif ($adaBaket) {

            $sheet->setCellValue("AB{$row}", "Baket");
            $sheet->setCellValueExplicit(
                "AD{$row}",
                (int) $hargaBaket,
                DataType::TYPE_NUMERIC
            );

            $sheet->getStyle("AD{$row}")
                ->getNumberFormat()
                ->setFormatCode('#,##0_);(#,##0)');

            $sheet->getStyle("AD{$row}")
                ->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        }

        /**
         * =========================
         * BREKER SAJA
         * =========================
         */
        elseif ($adaBreker) {

            $sheet->setCellValue("AB{$row}", "Breker");
            $sheet->setCellValueExplicit(
                "AD{$row}",
                (int) $hargaBreker,
                DataType::TYPE_NUMERIC
            );

            $sheet->getStyle("AD{$row}")
                ->getNumberFormat()
                ->setFormatCode('#,##0_);(#,##0)');

            $sheet->getStyle("AD{$row}")
                ->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        }


        // =============================
        // DP PEMBAYARAN (List DP)
        // =============================

        $dpList = $t->dpPembayaran;
        $dpRow = 15;
        $templateDpRow = 15;

        foreach ($dpList as $i => $dp) {

            if ($dpRow != $templateDpRow) {

                // 🔑 COPY STYLE FULL BARIS DP
                $sheet->duplicateStyle(
                    $sheet->getStyle("AQ{$templateDpRow}:AT{$templateDpRow}"),
                    "AQ{$dpRow}:AT{$dpRow}"
                );

                // 🔑 WAJIB merge ulang
                $sheet->mergeCells("AS{$dpRow}:AT{$dpRow}");
            }

            // Nomor urut → AQ
            $sheet->setCellValueExplicit(
                "AQ{$dpRow}",
                (string) ($i + 1),
                DataType::TYPE_STRING
            );

            // Tanggal → AR
            $sheet->setCellValue(
                "AR{$dpRow}",
                date('d-m-Y', strtotime($dp->tanggal))
            );

            // DP → AS–AT
            $sheet->mergeCells("AS{$dpRow}:AT{$dpRow}");

            $sheet->setCellValueExplicit(
                "AS{$dpRow}",
                (int) $dp->jumlah,
                DataType::TYPE_NUMERIC
            );

            // COPY FORMAT DARI TEMPLATE
            $sheet->duplicateStyle(
                $sheet->getStyle("AS{$templateDpRow}:AT{$templateDpRow}"),
                "AS{$dpRow}:AT{$dpRow}"
            );

            $dpRow++;
        }


        // =============================
        // GROUP TIMESHEET PER BULAN
        // =============================
        $grouped = $t->timesheets->groupBy(function ($ts) {
            return date('Y-m', strtotime($ts->tanggal));
        });

        $templateRow = 20;
        $currentRow  = 20;
        $nomor       = 1;

        $totalKeseluruhanJamBaket = 0;
        $totalKeseluruhanJamBreker = 0;

        // Kolom tanggal
        $dateColumns = [
            1=>'G',2=>'H',3=>'I',4=>'J',5=>'K',6=>'L',7=>'M',8=>'N',9=>'O',10=>'P',
            11=>'Q',12=>'R',13=>'S',14=>'T',15=>'U',16=>'V',17=>'W',18=>'X',
            19=>'Y',20=>'Z',21=>'AA',22=>'AB',23=>'AC',24=>'AD',25=>'AE',
            26=>'AF',27=>'AG',28=>'AH',29=>'AI',30=>'AJ',31=>'AK'
        ];

        $colTotalJam       = 'AL';
        $colHargaStart     = 'AM';
        $colHargaEnd       = 'AN';

        // =============================
        // LOOP PER BULAN
        // =============================
        // =============================
        // LOOP PER BULAN
        // =============================
        foreach ($grouped as $ym => $items) {

    // ============================================================
    // 1️⃣ BARIS HEADER BULAN (BARIS MANDIRI)
    // ============================================================
    if ($currentRow != $templateRow) {
        $sheet->insertNewRowBefore($currentRow, 1);
        $sheet->duplicateStyle($sheet->getStyle("C{$templateRow}:AN{$templateRow}"), "C{$currentRow}:AN{$currentRow}");
        $sheet->mergeCells("AM{$currentRow}:AN{$currentRow}");
    }

    // Set Judul Bulan
    $sheet->setCellValue("C{$currentRow}", $nomor);
    $nomor++;
    $sheet->mergeCells("D{$currentRow}:F{$currentRow}");
    $sheet->setCellValue("D{$currentRow}", date('F Y', strtotime("$ym-01")));
    
    // Style Font & Border (Wajib ada di tiap baris baru)
    $sheet->getStyle("C{$currentRow}:AN{$currentRow}")->getFont()->setName('Times New Roman')->setSize(12)->setBold(true);
    $sheet->getStyle("C{$currentRow}:AN{$currentRow}")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    $sheet->getStyle("D{$currentRow}:F{$currentRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    // Kosongkan kolom jam & harga di baris header bulan
    foreach ($dateColumns as $col) { 
        $sheet->setCellValue("{$col}{$currentRow}", ""); 
        $sheet->getStyle("{$col}{$currentRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    }
    $sheet->setCellValue("AL{$currentRow}", "");

// HANDLE HARGA SEWA (AM-AN)
$sheet->mergeCells("AM{$currentRow}:AN{$currentRow}");
$sheet->setCellValue("AM{$currentRow}", "");

// copy style biar sama kayak lainnya
$sheet->duplicateStyle(
    $sheet->getStyle("AM{$templateRow}:AN{$templateRow}"),
    "AM{$currentRow}:AN{$currentRow}"
);

    $currentRow++; // Loncat ke baris bawah untuk isi data pekerjaan

    // ============================================================
    // 2️⃣ BARIS BAKET
    // ============================================================
    if (in_array('baket', $jenisPekerjaan)) {
        $sheet->insertNewRowBefore($currentRow, 1);
        $sheet->duplicateStyle($sheet->getStyle("C{$templateRow}:AN{$templateRow}"), "C{$currentRow}:AN{$currentRow}");
        $sheet->mergeCells("AM{$currentRow}:AN{$currentRow}");

        // Label Pekerjaan
        $sheet->mergeCells("D{$currentRow}:F{$currentRow}");
        $sheet->setCellValue("D{$currentRow}", "Baket");
        $sheet->getStyle("D{$currentRow}:F{$currentRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Styling Baris
        $sheet->getStyle("C{$currentRow}:AN{$currentRow}")->getFont()->setName('Times New Roman')->setSize(12);
        $sheet->getStyle("C{$currentRow}:AN{$currentRow}")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // Isi Jam Baket
        $totalJamBaket = 0;
        foreach ($items as $ts) {
            $day = (int) date('j', strtotime($ts->tanggal));
            if (isset($dateColumns[$day]) && $ts->jam_baket > 0) {
                $totalJamBaket += (float)$ts->jam_baket;
                $sheet->setCellValue("{$dateColumns[$day]}{$currentRow}", $ts->jam_baket);
                $sheet->getStyle("{$dateColumns[$day]}{$currentRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            }
        }
        $totalKeseluruhanJamBaket += $totalJamBaket;
        
        // Total Jam (AL)
        $sheet->setCellValue("AL{$currentRow}", $totalJamBaket);
        $sheet->getStyle("AL{$currentRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Accounting Baket (AM-AN)
        $totalHargaBaket = $totalJamBaket * $hargaBaket;
        $sheet->setCellValueExplicit("AM{$currentRow}", (int)$totalHargaBaket, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
        $sheet->duplicateStyle($sheet->getStyle("AM{$templateRow}:AN{$templateRow}"), "AM{$currentRow}:AN{$currentRow}");

        $currentRow++; 
    }

    // ============================================================
    // 3️⃣ BARIS BREKER
    // ============================================================
    if (in_array('breker', $jenisPekerjaan)) {
        $sheet->insertNewRowBefore($currentRow, 1);
        $sheet->duplicateStyle($sheet->getStyle("C{$templateRow}:AN{$templateRow}"), "C{$currentRow}:AN{$currentRow}");
        $sheet->mergeCells("AM{$currentRow}:AN{$currentRow}");

        // Label Pekerjaan
        $sheet->mergeCells("D{$currentRow}:F{$currentRow}");
        $sheet->setCellValue("D{$currentRow}", "Breker");
        $sheet->getStyle("D{$currentRow}:F{$currentRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Styling Baris
        $sheet->getStyle("C{$currentRow}:AN{$currentRow}")->getFont()->setName('Times New Roman')->setSize(12);
        $sheet->getStyle("C{$currentRow}:AN{$currentRow}")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // Isi Jam Breker
        $totalJamBreker = 0;
        foreach ($items as $ts) {
            $day = (int) date('j', strtotime($ts->tanggal));
            if (isset($dateColumns[$day]) && $ts->jam_breker > 0) {
                $totalJamBreker += (float)$ts->jam_breker;
                $sheet->setCellValue("{$dateColumns[$day]}{$currentRow}", $ts->jam_breker);
                $sheet->getStyle("{$dateColumns[$day]}{$currentRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            }
        }
        $totalKeseluruhanJamBreker += $totalJamBreker;
        
        // Total Jam (AL)
        $sheet->setCellValue("AL{$currentRow}", $totalJamBreker);
        $sheet->getStyle("AL{$currentRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Accounting Breker
        $totalHargaBreker = $totalJamBreker * $hargaBreker;
        $sheet->setCellValueExplicit("AM{$currentRow}", (int)$totalHargaBreker, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
        $sheet->duplicateStyle($sheet->getStyle("AM{$templateRow}:AN{$templateRow}"), "AM{$currentRow}:AN{$currentRow}");

        // Warna Background Oranye Breker
        $sheet->getStyle("D{$currentRow}:AK{$currentRow}")->getFill()
              ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
              ->getStartColor()->setARGB('E97F4A');

        $currentRow++;
    }

    // ============================================================
    // 4️⃣ BARIS SPACER (KOSONG) - TETEP ADA BORDER BIAR RAPI
    // ============================================================
    $sheet->insertNewRowBefore($currentRow, 1);
    $sheet->duplicateStyle($sheet->getStyle("C{$templateRow}:AN{$templateRow}"), "C{$currentRow}:AN{$currentRow}");
    $sheet->mergeCells("D{$currentRow}:F{$currentRow}");
    $sheet->mergeCells("AM{$currentRow}:AN{$currentRow}");
    
    $sheet->getStyle("C{$currentRow}:AN{$currentRow}")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    $sheet->setCellValue("C{$currentRow}", "");
    $sheet->setCellValue("D{$currentRow}", "");
    $sheet->setCellValue("AL{$currentRow}", "");
    $sheet->setCellValue("AM{$currentRow}", "");

    $currentRow++;
}


        // ============================================================
        // ROW TOTAL (Dinamis Setelah Bulan Terakhir)
        // ============================================================
        $totalRow = $currentRow; // otomatis tepat di bawah bulan terakhir

        // $sheet->unmergeCells("D{$totalRow}:F{$totalRow}");
        $sheet->mergeCells("C{$totalRow}:AK{$totalRow}");
        $sheet->setCellValue("C{$totalRow}", "GRAND TOTAL");
                    // $sheet->setCellValue("Grand Total");

        $totalKeseluruhanJam = $totalKeseluruhanJamBaket + $totalKeseluruhanJamBreker;

            // Total Jam keseluruhan → AL
        $sheet->setCellValue("AL{$totalRow}", $totalKeseluruhanJam);
        $sheet->getStyle("AL{$totalRow}")
            ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Merge & isi total harga → AM–AN
        $sheet->mergeCells("AM{$totalRow}:AN{$totalRow}");

        // $totalHargaKeseluruhan = $totalKeseluruhanJam * $hargaBaket;
        $totalHargaKeseluruhan =
            ($totalKeseluruhanJamBaket  * $hargaBaket)
        + ($totalKeseluruhanJamBreker * $hargaBreker)
        + $t->biaya_modem;

        $sheet->setCellValue(
            "AM{$totalRow}",
            $totalHargaKeseluruhan
        );

        // $sheet->setCellValue(
        //     "AM{$totalRow}", $totalHargaKeseluruhan + $t->biaya_modem
        // );

        $sheet->getStyle("AM{$totalRow}:AN{$totalRow}")
            ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Border
        $sheet->getStyle("C{$totalRow}:AN{$totalRow}")
            ->getBorders()->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        // Font konsisten
        $sheet->getStyle("C{$totalRow}:AN{$totalRow}")
            ->getFont()->setName('Times New Roman')->setSize(12)->setBold(true);


        // =============================
        // OUTPUT FILE
        // =============================
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

        return new StreamedResponse(function () use ($writer) {
            $writer->save('php://output');
        }, 200, [
            "Content-Type"        => "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
            "Content-Disposition" => "attachment; filename=\"timesheet.xlsx\"",
        ]);
    }
}
