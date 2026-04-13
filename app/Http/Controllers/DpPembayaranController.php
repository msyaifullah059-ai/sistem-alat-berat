<?php

namespace App\Http\Controllers;

use Yajra\DataTables\Facades\DataTables;
use App\Models\DpPembayaran;
use App\Models\TransaksiSewa;
use Illuminate\Http\Request;

class DpPembayaranController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DpPembayaran::with(['transaksi.pelanggan', 'transaksi.alat'])->orderBy('tanggal', 'desc');

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('tanggal', fn($row) => $row->tanggal ? \Carbon\Carbon::parse($row->tanggal)->format('d/m/Y') : '-')
                ->editColumn('jumlah', fn($row) => 'Rp ' . number_format($row->jumlah, 0, ',', '.'))
                ->addColumn('pelanggan_alat', function($row) {
                    $pelanggan = $row->transaksi->pelanggan->nama ?? 'N/A';
                    $alat = $row->transaksi->alat->nama_alat ?? 'N/A';
                    return "<strong>$pelanggan</strong><br><small class='text-muted'>$alat</small>";
                })
                ->addColumn('action', function($row){
                    return '
                        <button type="button" onclick="editdp_pembayaran(\''.$row->id.'\')" class="btn btn-primary btn-icon btn-xs"><i class="mdi mdi-lead-pencil"></i></button>
                        <button type="button" onclick="deletedp_pembayaran(\''.$row->id.'\')" class="btn btn-danger btn-icon btn-xs"><i class="mdi mdi-delete"></i></button>';
                })
                ->rawColumns(['pelanggan_alat', 'action'])
                ->make(true);
        }

        $transaksi = TransaksiSewa::with(['pelanggan', 'alat'])->orderBy('id', 'desc')->get();
        return view('dp_pembayaran.index', compact('transaksi'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'transaksi_sewa_id' => 'required|exists:transaksi_sewas,id',
            'tanggal'           => 'required|date',
            'jumlah'            => 'required|integer|min:0',
            'keterangan'        => 'nullable|string',
        ]);

        DpPembayaran::create($validated);
        return response()->json(['success' => true, 'message' => 'DP berhasil ditambahkan!']);
    }

    public function edit($id)
    {
        return response()->json(DpPembayaran::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'transaksi_sewa_id' => 'required|exists:transaksi_sewas,id',
            'tanggal'           => 'required|date',
            'jumlah'            => 'required|integer|min:0',
            'keterangan'        => 'nullable|string',
        ]);

        DpPembayaran::findOrFail($id)->update($validated);
        return response()->json(['success' => true, 'message' => 'DP berhasil diperbarui!']);
    }

    public function destroy($id)
    {
        DpPembayaran::findOrFail($id)->delete();
        return response()->json(['success' => true, 'message' => 'DP berhasil dihapus!']);
    }
}