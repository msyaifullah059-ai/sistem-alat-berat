<?php

namespace App\Http\Controllers;

use App\Models\Operator;
use App\Models\AlatBerat;
use Illuminate\Http\Request;
use App\Models\TransaksiSewa;
use App\Models\DetailDpPembayaran;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // TOTAL
        $totalAlat = AlatBerat::count();

        $alatReady = AlatBerat::where('status', 'good')->count();

        $alatDisewa = AlatBerat::where('status', 'broken')->count();

        $alatMaintenance = AlatBerat::where('status', 'maintenance')->count();

        $totalOperator = Operator::count();

        $totalTransaksi = TransaksiSewa::count();

        $transaksiTerbaru = TransaksiSewa::latest()
    ->take(5)
    ->get();

        // TOTAL PENDAPATAN
        $totalPendapatan = DetailDpPembayaran::sum('jumlah');

        $totalStatusAlat = $alatReady + $alatDisewa + $alatMaintenance;

        $readyPercent = $totalStatusAlat > 0
            ? ($alatReady / $totalStatusAlat) * 100
            : 0;

        $disewaPercent = $totalStatusAlat > 0
            ? ($alatDisewa / $totalStatusAlat) * 100
            : 0;

        $maintenancePercent = $totalStatusAlat > 0
            ? ($alatMaintenance / $totalStatusAlat) * 100
            : 0;

            // CHART TRANSAKSI
            $chartTransaksi = TransaksiSewa::select(
                    DB::raw('MONTH(created_at) as bulan'),
                    DB::raw('COUNT(*) as total')
                )
                ->groupBy('bulan')
                ->orderBy('bulan')
                ->get();

            $bulan = [];

            $totalChart = [];

            foreach ($chartTransaksi as $chart) {

                $bulan[] = date('M', mktime(0, 0, 0, $chart->bulan, 1));

                $totalChart[] = $chart->total;
            }

        return view('dashboard.index', compact(
            'totalAlat',
            'alatReady',
            'alatDisewa',
            'alatMaintenance',
            'totalOperator',
            'totalTransaksi',
            'totalPendapatan',
            'transaksiTerbaru',
            'readyPercent',
            'disewaPercent',
            'maintenancePercent',
            'bulan',
            'totalChart'
        ));
    }
}