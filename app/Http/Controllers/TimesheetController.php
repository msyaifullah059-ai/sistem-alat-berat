<?php

namespace App\Http\Controllers;

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
                ->orderBy('created_at', 'desc')
                ->get();
            
            return DataTables::of($data)
                ->addColumn('pelanggan_alat', function($row) {
                    $pelanggan = $row->transaksi->pelanggan->nama ?? 'N/A';
                    $alat = $row->transaksi->alat->nama_alat ?? 'N/A';
                    return "<strong>$pelanggan</strong><br><small class='text-muted'>$alat</small>";
                })
                ->addColumn('sewa_lokasi', function($row) {
                    $jenis_sewa = $row->transaksi->jenis_sewa ?? 'N/A';
                    $lokasi = $row->transaksi->lokasi_proyek ?? 'N/A';
                    return "<strong>$jenis_sewa</strong><br><small class='text-muted'>$lokasi</small>";
                })
                ->addColumn('periode_sewa', function($row) {

                    $mulai = $row->transaksi->tanggal_mulai
                        ? \Carbon\Carbon::parse($row->tanggal_mulai)->format('d/m/Y')
                        : '-';

                    $selesai = $row->transaksi->tanggal_selesai
                        ? \Carbon\Carbon::parse($row->tanggal_selesai)->format('d/m/Y')
                        : '-';

                    return "
                        $mulai - $selesai
                    ";
                })
                ->addColumn('action', function($row){
                    return '
                        <button type="button"
                            onclick="detailTimesheet(\''.$row->id.'\')"
                            class="btn btn-info btn-icon btn-xs text-white"
                            title="Detail">

                            <i class="mdi mdi-eye"></i>

                        </button>

                        <button type="button" onclick="editTimesheet(\''.$row->id.'\')" class="btn btn-primary btn-icon btn-xs" title="Edit">
                            <i class="mdi mdi-lead-pencil"></i>
                        </button> 

                        <button type="button" onclick="deleteTimesheet(\''.$row->id.'\')" class="btn btn-danger btn-icon btn-xs title="Delete"">
                            <i class="mdi mdi-delete"></i>
                        </button>
                    ';
                })
                ->editColumn('status', function($row){
                    $val = $row->status;

                    $class = $val == 'Berjalan'
                        ? 'bg-warning'
                        : 'bg-success';

                    return '<span class="badge '.$class.'">'.$val.'</span>';
                })
                ->rawColumns(['pelanggan_alat', 'sewa_lokasi', 'status', 'action'])
                ->make(true);
        }

        $transaksi = TransaksiSewa::with(['pelanggan', 'alat'])->orderBy('id', 'desc')->get();
        return view('timesheet.index', compact('transaksi'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'transaksi_sewa_id' => 'required|exists:transaksi_sewas,id',
            'status'    => 'required|in:Berjalan,Selesai'
        ]);

        Timesheet::create($validated);

        return response()->json([
            'success' => true, 
            'message' => 'Timesheet berhasil disimpan!']);
    }

    public function edit($id)
    {
        return response()->json(Timesheet::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'transaksi_sewa_id' => 'required|exists:transaksi_sewas,id',
            'status' => 'required|in:Berjalan,Selesai'
        ]);

        $timesheet = Timesheet::findOrFail($id);
        $timesheet->update($validated);

        return response()->json([
            'success' => true, 
            'message' => 'Timesheet berhasil diupdate!']);
    }

    public function destroy($id)
    {
        Timesheet::findOrFail($id)->delete();
        return response()->json(['success' => true, 'message' => 'Data berhasil dihapus!']);
    }
}