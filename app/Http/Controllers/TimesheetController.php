<?php

namespace App\Http\Controllers;

// Geng Export Excel
use App\Exports\TimesheetTemplateExport;
use App\Exports\TimesheetExport;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\Timesheet;
use App\Models\TransaksiSewa;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TimesheetController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Timesheet::with(['transaksi.pelanggan', 'transaksi.alat'])
                ->orderBy('tanggal', 'desc')
                ->get();
            
            return DataTables::of($data)
                ->addColumn('action', function($row){
                    $btn = '<button type="button" onclick="editTimesheet(\''.$row->id.'\')" class="btn btn-primary btn-icon btn-xs">
                                <i class="mdi mdi-lead-pencil"></i>
                            </button> ';
                    
                    // Tombol Export satuan (jika diperlukan per baris)
                    $btn .= '<a href="'.route('timesheet.export', $row->transaksi_sewa_id).'" class="btn btn-success btn-icon btn-xs">
                                <i class="mdi mdi-file-excel"></i>
                            </a> ';

                    $btn .= '<button type="button" onclick="deleteTimesheet(\''.$row->id.'\')" class="btn btn-danger btn-icon btn-xs">
                                <i class="mdi mdi-delete"></i>
                            </button>';
                    return $btn;
                })
                ->rawColumns(['action']) 
                ->make(true);
        }

        $transaksi = TransaksiSewa::with(['pelanggan', 'alat'])->where('status', 'berjalan')->get();
        return view('timesheet.index', compact('transaksi'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'transaksi_sewa_id' => 'required|exists:transaksi_sewas,id',
            'tanggal'   => 'required|date',
            'tanggal_awal_hm'   => 'required|date',
            'tanggal_akhir_hm'  => 'required|date',
            'jam_baket'         => 'nullable|integer|min:0',
            'jam_breker'        => 'nullable|integer|min:0',
            'hm_awal'           => 'required|integer|min:0',
            'hm_akhir'          => 'required|integer|min:0'
        ]);

        $validated['jam_baket']  = $validated['jam_baket'] ?? 0;
        $validated['jam_breker'] = $validated['jam_breker'] ?? 0;

        Timesheet::create($validated);

        return response()->json(['success' => true, 'message' => 'Timesheet berhasil disimpan!']);
    }

    public function edit($id)
    {
        // Kita panggil Timesheet dengan relasi transaksi, lalu di dalam transaksi ada pelanggan & alat
        $timesheet = Timesheet::with(['transaksi.pelanggan', 'transaksi.alat'])->findOrFail($id);

        return response()->json([
            'timesheet' => $timesheet,
            // Lu nggak butuh kirim jenis_pekerjaan terpisah, 
            // karena udah nempel di dalam $timesheet->transaksi
        ]);
    }

    public function update(Request $request, $id)
    {
        $timesheet = Timesheet::findOrFail($id);

        $validated = $request->validate([
            'transaksi_sewa_id' => 'required|exists:transaksi_sewas,id',
            'tanggal'   => 'required|date',
            'tanggal_awal_hm'   => 'required|date',
            'tanggal_akhir_hm'  => 'required|date',
            'jam_baket'         => 'nullable|integer|min:0',
            'jam_breker'        => 'nullable|integer|min:0',
            'hm_awal'           => 'required|integer|min:0',
            'hm_akhir'          => 'required|integer|min:0'
        ]);

        $timesheet->update($validated);

        return response()->json(['success' => true, 'message' => 'Timesheet berhasil diupdate!']);
    }

    public function destroy($id)
    {
        Timesheet::findOrFail($id)->delete();
        return response()->json(['success' => true, 'message' => 'Data berhasil dihapus!']);
    }

    /**
     * Fitur Export yang lu minta bro
     */
    public function export($transaksiId)
    {
        // Tetep pake logic lu yang lama
        $export = new TimesheetTemplateExport();
        return $export->export($transaksiId);
    }
}