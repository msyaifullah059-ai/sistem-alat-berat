<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>SJ-{{ $transaksi->id }} | {{ $transaksi->pelanggan->nama }}</title>
    <style>
        @page {
            margin: 0.5cm;
        }

        body {
            font-family: 'Inter', 'Helvetica', Arial, sans-serif;
            font-size: 11px;
            color: #334155;
            line-height: 1.5;
            margin: 0;
            padding: 20px;
        }

        /* Watermark Modern */
        #watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            opacity: 0.04;
            z-index: -1000;
            width: 100%;
            text-align: center;
        }

        #watermark h1 {
            font-size: 70px;
            font-weight: 900;
            letter-spacing: 10px;
        }

        /* Header Section */
        .header-container {
            margin-bottom: 30px;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 15px;
        }

        .brand {
            font-size: 24px;
            font-weight: 800;
            color: #1e293b;
            letter-spacing: -1px;
        }

        .document-type {
            background: #1e293b;
            color: #fff;
            padding: 5px 15px;
            font-weight: bold;
            font-size: 14px;
            border-radius: 4px;
            display: inline-block;
            margin-top: 5px;
        }

        /* Info Grid */
        .grid {
            width: 100%;
            margin-bottom: 25px;
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
            margin-right: 10px;
        }

        .label {
            font-size: 9px;
            text-transform: uppercase;
            color: #64748b;
            font-weight: bold;
            margin-bottom: 4px;
        }

        .value {
            font-size: 12px;
            font-weight: 600;
            color: #0f172a;
        }

        /* Main Table */
        .table-main {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            border-radius: 8px;
            overflow: hidden;
        }

        .table-main th {
            background: #1e293b;
            color: #ffffff;
            padding: 12px;
            text-align: left;
            text-transform: uppercase;
            font-size: 10px;
        }

        .table-main td {
            padding: 12px;
            border-bottom: 1px solid #f1f5f9;
            background: #fff;
        }

        /* Condition Checklist (Visual Only) */
        .checklist-box {
            margin-top: 20px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 15px;
        }

        .checklist-title {
            font-weight: bold;
            margin-bottom: 10px;
            color: #1e293b;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }

        .check-item {
            display: inline-block;
            width: 23%;
            font-size: 10px;
            color: #475569;
        }

        .box {
            display: inline-block;
            width: 10px;
            height: 10px;
            border: 1px solid #94a3b8;
            margin-right: 5px;
            vertical-align: middle;
        }

        /* Signatures */
        .footer-sig {
            margin-top: 50px;
            width: 100%;
        }

        .sig-col {
            text-align: center;
            width: 33.33%;
            float: left;
        }

        .sig-line {
            margin: 40px auto 10px;
            width: 120px;
            border-bottom: 1px solid #1e293b;
        }

        .sig-name {
            font-weight: bold;
            font-size: 11px;
            color: #1e293b;
        }

        .note-footer {
            margin-top: 80px;
            font-size: 9px;
            color: #94a3b8;
            border-top: 1px dashed #e2e8f0;
            padding-top: 10px;
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

    <div class="header-container">
        <table style="width: 100%;">
            <tr>
                <td>
                    <div class="brand">CV. LISAN</div>
                    <div class="document-type">SURAT JALAN OPERASIONAL</div>
                </td>
                <td style="text-align: right; vertical-align: top;">
                    <div class="label">Nomor Dokumen</div>
                    <div class="value" style="font-size: 14px;">
                        SJ/SSA/{{ date('Y') }}/{{ str_pad($transaksi->id, 4, '0', STR_PAD_LEFT) }}</div>
                    <div class="label" style="margin-top: 8px;">Tanggal Terbit</div>
                    <div class="value">{{ date('d F Y') }}</div>
                </td>
            </tr>
        </table>
    </div>

    <table class="grid">
        <tr>
            <td>
                <div class="card">
                    <div class="label">Informasi Penyewa</div>
                    <div class="value">{{ $transaksi->pelanggan->nama }}</div>
                    <div style="margin-top: 5px; font-size: 11px; color: #64748b;">
                        {{ $transaksi->pelanggan->alamat }}<br>
                        Telp: {{ $transaksi->pelanggan->no_hp ?? '-' }}
                    </div>
                </div>
            </td>
            <td>
                <div class="card" style="margin-right: 0; margin-left: 10px;">
                    <div class="label">Detail Pengiriman</div>
                    <div class="value">Mobilisasi: {{ $transaksi->mobilisasi ?? 'Standard' }}</div>
                    <div style="margin-top: 5px; font-size: 11px; color: #64748b;">
                        Operator: <strong>{{ $transaksi->operator->nama ?? 'N/A' }}</strong><br>
                        Periode: {{ date('d/m/y', strtotime($transaksi->tanggal_mulai)) }} -
                        {{ date('d/m/y', strtotime($transaksi->tanggal_selesai)) }}
                    </div>
                </div>
            </td>
        </tr>
    </table>

    <table class="table-main">
        <thead>
            <tr>
                <th width="50%">Deskripsi Alat & Unit</th>
                <th width="25%">Jenis Pekerjaan</th>
                <th width="25%">Status Unit</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <div style="font-size: 13px; font-weight: bold; color: #1e293b;">{{ $transaksi->alat->nama_alat }}
                    </div>
                    <div style="font-size: 10px; color: #64748b; margin-top: 2px;">ID Unit:
                        SSA-{{ $transaksi->alat->id }}</div>
                </td>
                <td>
                    {{ ucwords(
                        is_array($transaksi->jenis_pekerjaan) ? implode(', ', $transaksi->jenis_pekerjaan) : $transaksi->jenis_pekerjaan,
                    ) }}
                </td>
                </td>
                <td><span style="color: #059669; font-weight: bold;">{{ ucfirst($transaksi->alat->status) }}</span>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="checklist-box">
        <div class="checklist-title">Checklist Fisik & Kelengkapan (Pre-Delivery)</div>
        <div class="check-item">
            <div class="box"></div> Oli Mesin
        </div>
        <div class="check-item">
            <div class="box"></div> Bahan Bakar
        </div>
        <div class="check-item">
            <div class="box"></div> Hidrolik
        </div>
        <div class="check-item">
            <div class="box"></div> Kebersihan
        </div>
        <div class="check-item">
            <div class="box"></div> Lampu/Kelistrikan
        </div>
        <div class="check-item">
            <div class="box"></div> Tools/Kunci
        </div>
        <div class="check-item">
            <div class="box"></div> Spare Tire/Track
        </div>
        <div class="check-item">
            <div class="box"></div> APAR
        </div>
    </div>

    <div class="footer-sig clearfix">
        <div class="sig-col">
            <div class="label">Admin Logistic</div>
            <div class="sig-line"></div>
            <div class="sig-name">( Shany Sasnita A. )</div>
        </div>
        <div class="sig-col">
            <div class="label">Operator Lapangan</div>
            <div class="sig-line"></div>
            <div class="sig-name">( {{ $transaksi->operator->nama ?? '..........' }} )</div>
        </div>
        <div class="sig-col">
            <div class="label">Penerima (Site Manager)</div>
            <div class="sig-line"></div>
            <div class="sig-name">( {{ $transaksi->pelanggan->nama }} )</div>
        </div>
    </div>

    <div class="note-footer">
        <strong>PENTING:</strong> Segala kerusakan unit yang terjadi di lokasi proyek akibat kelalaian operasional
        menjadi tanggung jawab penyewa sesuai kesepakatan. Harap lapor jika unit mengalami kendala teknis dalam 1x24
        jam.
    </div>

</body>

</html>
