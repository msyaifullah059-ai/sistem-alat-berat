@extends('admin')

@section('title', 'Dashboard')

@section('content')

    @php
        $user = auth()->user();
    @endphp

    <style>
        body {
            background: var(--bs-body-bg);
            color: var(--bs-body-color);
        }

        /* =========================
            HERO
            ========================= */

        .premium-hero {
            position: relative;
            overflow: hidden;
            border-radius: 28px;
            border: 1px solid var(--bs-border-color);

            background:
                linear-gradient(135deg,
                    rgba(37, 99, 235, 0.95),
                    rgba(124, 58, 237, 0.90));

            box-shadow:
                0 20px 60px rgba(37, 99, 235, .18);
        }

        .premium-hero::before {
            content: '';
            position: absolute;
            width: 350px;
            height: 350px;
            background: rgba(255, 255, 255, .08);
            border-radius: 50%;
            top: -120px;
            right: -100px;
        }

        .premium-hero::after {
            content: '';
            position: absolute;
            width: 250px;
            height: 250px;
            background: rgba(255, 255, 255, .05);
            border-radius: 50%;
            bottom: -100px;
            left: -100px;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        /* =========================
            PREMIUM CARD
            ========================= */

        .premium-card {
            position: relative;
            overflow: hidden;

            border-radius: 24px;

            background: var(--bs-body-bg);

            border: 1px solid var(--bs-border-color);

            box-shadow:
                0 10px 35px rgba(15, 23, 42, .05);

            transition: .35s ease;
        }

        .premium-card:hover {
            transform: translateY(-6px);

            box-shadow:
                0 20px 45px rgba(15, 23, 42, .08);
        }

        /* =========================
            ICON
            ========================= */

        .stats-icon {
            width: 62px;
            height: 62px;
            border-radius: 18px;

            display: flex;
            align-items: center;
            justify-content: center;
        }

        .analytics-number {
            font-size: 30px;
            font-weight: 700;
            letter-spacing: -.5px;

            color: var(--bs-body-color);
        }

        /* =========================
            BADGE
            ========================= */

        .mini-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;

            padding: 5px 10px;

            border-radius: 999px;

            font-size: 12px;
            font-weight: 600;
        }

        /* =========================
            SECTION
            ========================= */

        .glass-section {
            background: var(--bs-body-bg);

            border: 1px solid var(--bs-border-color);

            border-radius: 24px;

            box-shadow:
                0 10px 35px rgba(15, 23, 42, .04);
        }

        .section-title {
            font-size: 18px;
            font-weight: 700;

            color: var(--bs-body-color);
        }

        .section-subtitle {
            font-size: 13px;

            color: var(--bs-secondary-color);
        }

        /* =========================
            ACTIVITY
            ========================= */

        .activity-item {
            padding: 14px;

            border-radius: 18px;

            background: var(--bs-tertiary-bg);

            transition: .3s;
        }

        .activity-item:hover {
            background: rgba(var(--bs-secondary-bg-rgb), .8);
        }

        /* =========================
            STATUS
            ========================= */

        .status-box {
            padding: 18px;

            border-radius: 18px;

            background: var(--bs-tertiary-bg);

            border: 1px solid var(--bs-border-color);
        }

        .progress {
            height: 7px;

            border-radius: 999px;

            overflow: hidden;

            background: rgba(148, 163, 184, .2);
        }

        /* =========================
            TABLE
            ========================= */

        .table-premium {
            color: var(--bs-body-color);
        }

        .table-premium thead th {
            border: none;

            color: var(--bs-secondary-color);

            font-size: 13px;
            font-weight: 600;
        }

        .table-premium tbody td {
            border-color: var(--bs-border-color);

            vertical-align: middle;

            padding-top: 18px;
            padding-bottom: 18px;
        }

        .table-premium tbody tr:hover {
            background: rgba(148, 163, 184, .04);
        }

        /* =========================
            BADGE
            ========================= */

        .machine-badge {
            padding: 6px 12px;

            border-radius: 999px;

            font-size: 12px;
            font-weight: 600;
        }

        /* =========================
            LIVE DOT
            ========================= */

        .floating-dot {
            width: 10px;
            height: 10px;

            border-radius: 50%;

            background: #22c55e;

            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {

            0% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.5);
                opacity: .5;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    {{-- HERO --}}
    <div class="card premium-hero mb-4">

        <div class="card-body p-4 p-lg-5 hero-content">

            <div class="row align-items-center">

                <div class="col-lg-8">

                    <div class="d-flex align-items-center gap-2 mb-3">

                        <div class="floating-dot"></div>

                        <span class="text-white-50">
                            Live Monitoring Dashboard
                        </span>

                    </div>

                    <h2 class="fw-bold text-white mb-3">
                        Welcome, {{ $user->name }} 👋
                    </h2>

                    <p class="text-white-50 mb-4 fs-15px">
                        Monitor heavy equipment operations, track rental activity,
                        and manage company performance in real-time.
                    </p>

                    <div class="d-flex flex-wrap gap-3">

                        <div class="mini-badge bg-white text-dark">
                            <i data-lucide="calendar" class="icon-sm"></i>
                            {{ now()->translatedFormat('l, d F Y') }}
                        </div>

                        <div class="mini-badge bg-dark text-white">
                            <i data-lucide="activity" class="icon-sm"></i>
                            System Running Normally
                        </div>

                    </div>

                </div>

                <div class="col-lg-4 text-end d-none d-lg-block">

                    <i data-lucide="layout-dashboard" style="width:160px;height:160px;opacity:.10;color:white;"></i>

                </div>

            </div>

        </div>

    </div>

    {{-- ANALYTICS --}}
    <div class="row">

        {{-- TOTAL ALAT --}}
        <div class="col-md-6 col-xl-3 grid-margin stretch-card">

            <div class="card premium-card">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-start mb-4">

                        <div>

                            <p class="text-secondary mb-2">
                                Total Alat
                            </p>

                            <h3 class="analytics-number mb-2">
                                {{ $totalAlat }}
                            </h3>

                            <div class="mini-badge bg-success-subtle text-success">
                                <i data-lucide="trending-up" class="icon-xs"></i>
                                +5 bulan ini
                            </div>

                        </div>

                        <div class="stats-icon bg-primary-subtle text-primary">

                            <i data-lucide="truck"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- OPERATOR --}}
        <div class="col-md-6 col-xl-3 grid-margin stretch-card">

            <div class="card premium-card">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-start mb-4">

                        <div>

                            <p class="text-secondary mb-2">
                                Total Operator
                            </p>

                            <h3 class="analytics-number mb-2">
                                {{ $totalOperator }}
                            </h3>

                            <div class="mini-badge bg-success-subtle text-success">
                                <i data-lucide="trending-up" class="icon-xs"></i>
                                +2 operator
                            </div>

                        </div>

                        <div class="stats-icon bg-success-subtle text-success">

                            <i data-lucide="users"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- TRANSAKSI --}}
        <div class="col-md-6 col-xl-3 grid-margin stretch-card">

            <div class="card premium-card">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-start mb-4">

                        <div>

                            <p class="text-secondary mb-2">
                                Total Transaksi
                            </p>

                            <h3 class="analytics-number mb-2">
                                {{ $totalTransaksi }}
                            </h3>

                            <div class="mini-badge bg-warning-subtle text-warning">
                                <i data-lucide="activity" class="icon-xs"></i>
                                +12 transaksi
                            </div>

                        </div>

                        <div class="stats-icon bg-warning-subtle text-warning">

                            <i data-lucide="file-text"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- PENDAPATAN --}}
        <div class="col-md-6 col-xl-3 grid-margin stretch-card">

            <div class="card premium-card">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-start mb-4">

                        <div>

                            <p class="text-secondary mb-2">
                                Pendapatan
                            </p>

                            <h3 class="analytics-number mb-2">
                                Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                            </h3>

                            <div class="mini-badge bg-danger-subtle text-danger">
                                <i data-lucide="wallet" class="icon-xs"></i>
                                +8.2%
                            </div>

                        </div>

                        <div class="stats-icon bg-danger-subtle text-danger">

                            <i data-lucide="wallet"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- CHART + STATUS --}}
    <div class="row">

        {{-- CHART --}}
        <div class="col-lg-8 grid-margin stretch-card">

            <div class="card glass-section">

                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-center mb-4">

                        <div>

                            <h5 class="section-title mb-1">
                                Grafik Penyewaan
                            </h5>

                            <p class="section-subtitle mb-0">
                                Rental analytics performance this month
                            </p>

                        </div>

                        <div class="mini-badge bg-primary-subtle text-primary">
                            Monthly Report
                        </div>

                    </div>

                    <div id="rentalChart" style="height: 320px;"></div>

                </div>

            </div>

        </div>

        {{-- STATUS --}}
        <div class="col-lg-4 grid-margin stretch-card">

            <div class="card glass-section">

                <div class="card-body p-4">

                    <h5 class="section-title mb-4">
                        Status Alat
                    </h5>

                    <div class="d-flex flex-column gap-3">

                        {{-- READY --}}
                        <div class="status-box">

                            <div class="d-flex justify-content-between mb-2">

                                <span>Ready</span>

                                <div class="text-end">

                                    <div class="fw-bold text-success">
                                        {{ $alatReady }} Unit
                                    </div>

                                </div>

                            </div>
                            <div class="d-flex align-items-center gap-2">

                                <div class="progress flex-grow-1">

                                    <div class="progress-bar bg-success" style="width: {{ $readyPercent }}%">
                                    </div>

                                </div>

                                <small class="fw-semibold text-muted">
                                    {{ number_format($readyPercent, 1) }}%
                                </small>

                            </div>

                        </div>

                        <div class="status-box">

                            <div class="d-flex justify-content-between mb-2">

                                <span>Disewa</span>

                                <div class="text-end">

                                    <div class="fw-bold text-primary">
                                        {{ $alatDisewa }} Unit
                                    </div>

                                </div>

                            </div>

                            <div class="d-flex align-items-center gap-2">

                                <div class="progress flex-grow-1">

                                    <div class="progress-bar bg-primary" style="width: {{ $disewaPercent }}%">
                                    </div>

                                </div>

                                <small class="fw-semibold text-muted">
                                    {{ number_format($disewaPercent, 1) }}%
                                </small>

                            </div>

                        </div>

                        <div class="status-box">

                            <div class="d-flex justify-content-between mb-2">

                                <span>Maintenance</span>

                                <div class="text-end">

                                    <div class="fw-bold text-warning">
                                        {{ $alatMaintenance }} Unit
                                    </div>

                                </div>

                            </div>

                            <div class="d-flex align-items-center gap-2">

                                <div class="progress flex-grow-1">

                                    <div class="progress-bar bg-warning" style="width: {{ $maintenancePercent }}%">
                                    </div>

                                </div>

                                <small class="fw-semibold text-muted">
                                    {{ number_format($maintenancePercent, 1) }}%
                                </small>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- TABLE + ACTIVITY --}}
    <div class="row">

        {{-- TABLE --}}
        <div class="col-lg-12 grid-margin stretch-card">

            <div class="card glass-section">

                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-center mb-4">

                        <div>

                            <h5 class="section-title mb-1">
                                Transaksi Terbaru
                            </h5>

                            <p class="section-subtitle mb-0">
                                Recent heavy equipment rental activity
                            </p>

                        </div>

                    </div>

                    <div class="table-responsive">

                        <table class="table table-premium">

                            <thead>

                                <tr>
                                    <th>Pelanggan</th>
                                    <th>Alat</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>

                            </thead>

                            <tbody>

                                @foreach ($transaksiTerbaru as $item)
                                    <tr>

                                        <td>{{ $item->pelanggan->nama }}</td>

                                        <td>{{ $item->alat->nama_alat }}</td>

                                        <td>
                                            {{ \Carbon\Carbon::parse($item->tanggal_selesai)->translatedFormat('d F Y') }}
                                        </td>

                                        <td>
                                            {{ \Carbon\Carbon::parse($item->tanggal_mulai)->translatedFormat('d F Y') }}
                                        </td>

                                        <td>
                                            Rp {{ number_format($item->dpPembayaran->jumlah, 0, ',', '.') }}
                                        </td>


                                        <td>

                                            <span class="machine-badge bg-success-subtle text-success">
                                                {{ $item->status }}
                                            </span>

                                        </td>

                                    </tr>
                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection


@push('scripts')
    <script>
        var options = {

            series: [{
                name: 'Transaksi',
                data: @json($totalChart)
            }],

            chart: {
                type: 'area',
                height: 320,
                toolbar: {
                    show: false
                }
            },

            stroke: {
                curve: 'smooth',
                width: 3
            },

            dataLabels: {
                enabled: false
            },

            xaxis: {
                categories: @json($bulan)
            },

            colors: ['#2563eb'],

            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.4,
                    opacityTo: 0.1,
                }
            }

        };

        var chart = new ApexCharts(
            document.querySelector("#rentalChart"),
            options
        );

        chart.render();
    </script>
@endpush
