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
            $data = DpPembayaran::with(['transaksi.pelanggan', 'transaksi.alat'])->orderBy('created_at', 'desc');

            return DataTables::of($data)
                ->addColumn('pelanggan_alat', function($row) {
                    $pelanggan = $row->transaksi->pelanggan->nama ?? 'N/A';
                    $alat = $row->transaksi->alat->nama_alat ?? 'N/A';
                    return "<strong>$pelanggan</strong><br><small class='text-muted'>$alat</small>";
                })
                ->addColumn('action', function($row){

    return '

        <button type="button"
            onclick="detaildp_pembayaran(\''.$row->id.'\')"
            class="btn btn-info btn-icon btn-xs text-white"
            title="Detail">

            <i class="mdi mdi-eye"></i>

        </button>

        <button type="button"
            onclick="editdp_pembayaran(\''.$row->id.'\')"
            class="btn btn-primary btn-icon btn-xs"
            title="Edit">

            <i class="mdi mdi-lead-pencil"></i>

        </button>

        <button type="button"
            onclick="deletedp_pembayaran(\''.$row->id.'\')"
            class="btn btn-danger btn-icon btn-xs"
            title="Delete">

            <i class="mdi mdi-delete"></i>

        </button>

    ';
})
                ->editColumn('status', function($row){
                    $val = $row->status;
                    $class = $val == 'Belum Lunas' ? 'bg-warning' : ($val == 'Lunas' ? 'bg-success' : 'bg-danger');
                    return '<span class="badge '.$class.'">'.$val.'</span>';
                })
                ->rawColumns(['pelanggan_alat', 'status', 'action'])
                ->make(true);
        }

        $transaksi = TransaksiSewa::with(['pelanggan', 'alat'])->orderBy('id', 'desc')->get();
        return view('dp_pembayaran.index', compact('transaksi'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([

            'dp_pembayaran_id' => 'required|exists:dp_pembayarans,id',

            'tanggal_bayar' => 'required|date',

            'jumlah' => 'required|integer|min:0',

            'keterangan' => 'nullable|string',

            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // UPLOAD FOTO
        if ($request->hasFile('gambar')) {

            $validated['gambar'] = $request
                ->file('gambar')
                ->store('detail_pembayaran', 'public');
        }

        DetailDpPembayaran::create($validated);

        // TOTAL BARU
        $total = DetailDpPembayaran::where(
            'dp_pembayaran_id',
            $validated['dp_pembayaran_id']
        )->sum('jumlah');

        return response()->json([

            'success' => true,

            'message' => 'Detail pembayaran berhasil ditambahkan!',

            'total' => $total
        ]);
    }

    public function edit($id)
    {
        return response()->json(DpPembayaran::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $detail = DetailDpPembayaran::findOrFail($id);

        $validated = $request->validate([

            'tanggal_bayar' => 'required|date',

            'jumlah' => 'required|integer|min:0',

            'keterangan' => 'nullable|string',

            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // UPDATE FOTO
        if ($request->hasFile('gambar')) {

            if ($detail->gambar) {

                Storage::disk('public')
                    ->delete($detail->gambar);
            }

            $validated['gambar'] = $request
                ->file('gambar')
                ->store('detail_pembayaran', 'public');
        }

        $detail->update($validated);

        // TOTAL BARU
        $total = DetailDpPembayaran::where(
            'dp_pembayaran_id',
            $detail->dp_pembayaran_id
        )->sum('jumlah');

        return response()->json([

            'success' => true,

            'message' => 'Detail pembayaran berhasil diupdate!',

            'total' => $total
        ]);
    }

    public function destroy($dp_pembayaran_id, $id)
    {
        $detail = DetailDpPembayaran::findOrFail($id);

        // SIMPAN ID DULU
        $dpId = $detail->dp_pembayaran_id;

        // HAPUS FOTO
        if ($detail->gambar) {

            Storage::disk('public')
                ->delete($detail->gambar);
        }

        $detail->delete();

        // TOTAL BARU
        $total = DetailDpPembayaran::where(
            'dp_pembayaran_id',
            $dpId
        )->sum('jumlah');

        return response()->json([

            'success' => true,

            'message' => 'Detail pembayaran berhasil dihapus!',

            'total' => $total
        ]);
    }
}