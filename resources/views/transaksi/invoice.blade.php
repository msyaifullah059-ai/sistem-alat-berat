<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>INV {{ $transaksi->pelanggan->nama }} - CV. Lisan</title>
    <style>
        /* Setup Halaman */
        @page {
            margin: 0.5cm;
        }

        body {
            /* Mengikuti font Surat Jalan yang modern */
            font-family: 'Inter', 'Helvetica', 'Arial', sans-serif;
            font-size: 11px;
            color: #334155;
            line-height: 1.5;
            margin: 0;
            padding: 20px;
        }

        /* Watermark Modern (Sesuai Surat Jalan) */
        #watermark {
            position: fixed;
            top: 41%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            opacity: 0.04;
            z-index: -1000;
            width: 100%;
            text-align: center;
        }

        #watermark h1 {
            font-size: 50px;
            /* Ukuran disamakan dengan SJ */
            font-weight: 900;
            letter-spacing: 10px;
            margin: 0;
        }

        /* Header & Brand */
        .header-container {
            margin-bottom: 30px;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 15px;
        }

        .brand {
            font-size: 24px;
            font-weight: 800;
            /* Lebih bold sesuai SJ */
            color: #1e293b;
            letter-spacing: -1px;
        }

        .document-type {
            background: #1e293b;
            color: #fff;
            padding: 5px 15px;
            font-weight: bold;
            font-size: 13px;
            border-radius: 4px;
            display: inline-block;
            margin-top: 5px;
        }

        /* Status Lunas Stamp */
        .status-stamp {
            position: absolute;
            top: 180px;
            right: 30px;
            border: 4px solid #059669;
            color: #059669;
            padding: 10px 20px;
            font-size: 15px;
            /* Sedikit lebih besar dari sebelumnya biar proporsional */
            font-weight: 900;
            transform: rotate(-15deg);
            opacity: 0.2;
            z-index: 100;
            border-radius: 8px;
        }

        /* Info Grid (Gaya Card Surat Jalan) */
        .grid {
            width: 100%;
            margin-bottom: 25px;
            border-collapse: collapse;
        }

        .grid td {
            vertical-align: top;
            width: 50%;
        }

        .card {
            background: #f8fafc;
            border: 1px solid #f1f5f9;
            padding: 12px;
            border-radius: 8px;
        }

        .label {
            font-size: 9px;
            text-transform: uppercase;
            color: #64748b;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .value {
            font-size: 12px;
            font-weight: 600;
            color: #0f172a;
        }

        /* Table Style */
        .table-main {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .table-main th {
            background: #1e293b;
            color: #ffffff;
            padding: 12px;
            text-align: left;
            text-transform: uppercase;
            font-size: 10px;
            letter-spacing: 0.5px;
        }

        .table-main td {
            padding: 12px;
            border-bottom: 1px solid #f1f5f9;
        }

        .total-row {
            background: #1e293b !important;
            color: #ffffff;
            font-weight: 800;
        }

        /* Bank Info Card */
        .bank-box {
            margin-top: 25px;
            border: 1px dashed #cbd5e1;
            padding: 15px;
            border-radius: 8px;
            width: 65%;
            /* Sedikit lebih lebar biar muat teks bank */
            background: #fff;
        }

        /* Signatures */
        .footer-sig {
            margin-top: 45px;
            width: 100%;
        }

        .sig-col {
            text-align: center;
            width: 40%;
            float: right;
        }

        .sig-line {
            margin: 40px auto 10px;
            width: 160px;
            border-bottom: 1.5px solid #1e293b;
        }

        .sig-name {
            font-weight: 700;
            font-size: 11px;
            color: #1e293b;
        }

        .note-footer {
            margin-top: 80px;
            font-size: 9px;
            color: #94a3b8;
            border-top: 1px dashed #e2e8f0;
            padding-top: 10px;
            line-height: 1.6;
        }

        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
    </style>
</head>

<body>
    <div id="watermark">
        <h1>CV. LISAN</h1>
    </div>

    @if ($transaksi->status == 'selesai')
        <div class="status-stamp">PAID / LUNAS</div>
    @endif

    <div class="header-container">
        <table style="width: 100%;">
            <tr>
                <td>
                    <div class="brand">CV. LISAN</div>
                    <div class="document-type">INVOICE PENAGIHAN</div>
                </td>
                <td style="text-align: right; vertical-align: top;">
                    <div class="label" style="letter-spacing: 1px;">Nomor Invoice</div>
                    <div class="value" style="font-size: 14px;">
                        {{ $no_invoice ?? 'SSA-INV/' . str_pad($transaksi->id, 4, '0', STR_PAD_LEFT) }}
                    </div>
                    <div class="label" style="margin-top: 8px; letter-spacing: 1px;">Tanggal Terbit</div>
                    <div class="value">{{ date('d F Y') }}</div>
                </td>
            </tr>
        </table>
    </div>

    <table class="grid">
        <tr>
            <td style="padding-right: 10px;">
                <div class="card">
                    <div class="label">Ditujukan Kepada</div>
                    <div class="value">{{ $transaksi->pelanggan->nama }}</div>
                    <div style="margin-top: 5px; font-size: 11px; color: #64748b; font-weight: 400;">
                        {{ $transaksi->pelanggan->alamat }}<br>
                        Telp: {{ $transaksi->pelanggan->no_hp ?? '-' }}
                    </div>
                </div>
            </td>
            <td style="padding-left: 10px;">
                <div class="card">
                    <div class="label">Detail Sewa</div>
                    <div class="value">{{ $transaksi->alat->nama_alat }}</div>
                    <div style="margin-top: 5px; font-size: 11px; color: #64748b; font-weight: 400;">
                        Periode: {{ date('d/m/Y', strtotime($transaksi->tanggal_mulai)) }} -
                        {{ date('d/m/Y', strtotime($transaksi->tanggal_selesai)) }}<br>
                        Jatuh Tempo: <strong>{{ date('d F Y', strtotime('+3 days')) }}</strong>
                    </div>
                </div>
            </td>
        </tr>
    </table>

    <table class="table-main">
        <thead>
            <tr>
                <th>Deskripsi Layanan / Item</th>
                <th style="text-align: right;">Subtotal (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <div style="font-weight: 700; color: #1e293b;">Sewa Unit Utama</div>
                    <div style="font-size: 10px; color: #64748b; margin-top: 2px;">Lokasi Proyek:
                        {{ $transaksi->lokasi_proyek }}</div>
                </td>
                <td align="right" style="color: #94a3b8;">--</td>
            </tr>
            @if ($transaksi->harga_sewa_baket > 0)
                <tr>
                    <td>Biaya Sewa Baket (Excavator Attachment)</td>
                    <td align="right">{{ number_format($transaksi->harga_sewa_baket, 0, ',', '.') }}</td>
                </tr>
            @endif
            @if ($transaksi->harga_sewa_breker > 0)
                <tr>
                    <td>Biaya Sewa Breker (Hydraulic Breaker)</td>
                    <td align="right">{{ number_format($transaksi->harga_sewa_breker, 0, ',', '.') }}</td>
                </tr>
            @endif
            <tr>
                <td>Mobilisasi</td>
                <td align="right">{{ $transaksi->mobilisasi ?? 'As Requested' }}</td>
            </tr>
            <tr>
                <td>Demobilisasi</td>
                <td align="right">{{ $transaksi->demobilisasi ?? 'As Requested' }}</td>
            </tr>
            @if ($transaksi->biaya_modem > 0)
                <tr>
                    <td>Biaya Modem (Operasional)</td>
                    <td align="right">{{ number_format($transaksi->biaya_modem, 0, ',', '.') }}</td>
                </tr>
            @endif
            <tr class="total-row">
                <td style="text-align: right; letter-spacing: 1px;">GRAND TOTAL</td>
                <td align="right" style="font-size: 13px;">Rp {{ number_format($total, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="bank-box">
        <div class="label" style="color: #1e293b; margin-bottom: 8px;">Informasi Pembayaran</div>
        <table style="width: 100%; font-size: 11px;">
            <tr>
                <td width="30%" style="color: #64748b;">Nama Bank</td>
                <td width="5%">:</td>
                <td style="font-weight: 700; color: #0f172a;">BANK MANDIRI / BCA</td>
            </tr>
            <tr>
                <td style="color: #64748b;">No. Rekening</td>
                <td>:</td>
                <td style="font-weight: 700; color: #0f172a;">123-456-7890 / 098-765-4321</td>
            </tr>
            <tr>
                <td style="color: #64748b;">Atas Nama</td>
                <td>:</td>
                <td style="font-weight: 700; color: #0f172a;">CV. LISAN</td>
            </tr>
        </table>
    </div>

    <div class="footer-sig clearfix">
        <div class="sig-col">
            <div class="label">Finance Manager,</div>
            <div class="sig-line"></div>
            <div class="sig-name">Shany Sasnita Andriani</div>
            <div style="font-size: 9px; color: #64748b; font-weight: 400; margin-top: 2px;">CV. Lisan - Head Office
            </div>
        </div>
    </div>

    <div class="note-footer">
        <strong>CATATAN PENTING:</strong><br>
        1. Pembayaran dianggap sah jika dana sudah masuk ke rekening perusahaan CV. Lisan.<br>
        2. Harap lampirkan bukti transfer melalui kanal WhatsApp resmi kami untuk percepatan proses administrasi.<br>
        3. Invoice ini diterbitkan secara resmi melalui Sistem Informasi Manajemen perusahaan.
    </div>
</body>

</html>
