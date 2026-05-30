<?php

namespace App\Http\Controllers;

use App\Models\DpPembayaran;
use Illuminate\Http\Request;
use App\Models\DetailDpPembayaran;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class DetailDpPembayaranController extends Controller
{
    /**
     * INDEX
     */
    public function index(Request $request, $dp_pembayaran)
    {
        $pembayaran = DpPembayaran::with([
            'transaksi.pelanggan',
            'transaksi.alat'
        ])->findOrFail($dp_pembayaran);

        // 🔥 TOTAL PEMBAYARAN (INITIAL LOAD)
        $jumlah = DetailDpPembayaran::where('dp_pembayaran_id', $dp_pembayaran)
            ->sum('jumlah');

        if ($request->ajax()) {

            $data = DetailDpPembayaran::where('dp_pembayaran_id', $dp_pembayaran)
                ->orderBy('tanggal_bayar', 'desc');

            return DataTables::of($data)
                ->addIndexColumn()

                ->editColumn('tanggal_bayar', function ($row) {
                    return $row->tanggal_bayar
                        ? \Carbon\Carbon::parse($row->tanggal_bayar)->format('d/m/Y')
                        : '-';
                })

                ->editColumn('jumlah', function ($row) {
                    return 'Rp ' . number_format($row->jumlah, 0, ',', '.');
                })

                ->addColumn('gambar', function ($row) {
                    if ($row->gambar) {
                        $url = asset('storage/' . $row->gambar);

                        return '
                            <img src="'.$url.'"
                                width="50"
                                height="50"
                                class="rounded shadow-sm"
                                style="object-fit:cover; cursor:pointer;"
                                onclick="showGambar(\''.$url.'\')">
                        ';
                    }

                    return '<small class="text-muted">No Image</small>';
                })

                ->addColumn('action', function ($row) use ($dp_pembayaran) {
                    return '
                        <button type="button"
                            onclick="editDetail(\''.$row->id.'\')"
                            class="btn btn-primary btn-icon btn-xs">
                            <i class="mdi mdi-lead-pencil"></i>
                        </button>

                        <button type="button"
                            onclick="deleteDetail(\''.$dp_pembayaran.'\', \''.$row->id.'\')"
                            class="btn btn-danger btn-icon btn-xs">
                            <i class="mdi mdi-delete"></i>
                        </button>
                    ';
                })

                ->rawColumns(['gambar', 'action'])
                ->make(true);
        }

        return view('dp_pembayaran.detail.index', compact(
            'pembayaran',
            'jumlah',
            'dp_pembayaran'
        ));
    }

    /**
     * STORE
     */
    public function store(Request $request, $dp_pembayaran)
    {
        $validated = $request->validate([
            'tanggal_bayar' => 'required|date',
            'jumlah' => 'required|integer|min:0',
            'keterangan' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $validated['dp_pembayaran_id'] = $dp_pembayaran;

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')
                ->store('detail_pembayaran', 'public');
        }

        DetailDpPembayaran::create($validated);

        // 🔥 TOTAL TERBARU
        $total = DetailDpPembayaran::where('dp_pembayaran_id', $dp_pembayaran)
            ->sum('jumlah');

        return response()->json([
            'success' => true,
            'message' => 'Detail pembayaran berhasil ditambahkan!',
            'total'   => $total
        ]);
    }

    /**
     * EDIT
     */
    public function edit($dp_pembayaran, $detail_dp_pembayaran)
    {
        $detail = DetailDpPembayaran::findOrFail($detail_dp_pembayaran);

        return response()->json($detail);
    }

    /**
     * UPDATE
     */
    public function update(Request $request, $dp_pembayaran, $detail_dp_pembayaran)
    {
        $detail = DetailDpPembayaran::findOrFail($detail_dp_pembayaran);

        $validated = $request->validate([
            'tanggal_bayar' => 'required|date',
            'jumlah' => 'required|integer|min:0',
            'keterangan' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($request->hasFile('gambar')) {

            if ($detail->gambar) {
                Storage::disk('public')->delete($detail->gambar);
            }

            $validated['gambar'] = $request->file('gambar')
                ->store('detail_pembayaran', 'public');
        }

        $detail->update($validated);

        // 🔥 TOTAL TERBARU
        $total = DetailDpPembayaran::where('dp_pembayaran_id', $dp_pembayaran)
            ->sum('jumlah');

        return response()->json([
            'success' => true,
            'message' => 'Detail pembayaran berhasil diupdate!',
            'total'   => $total
        ]);
    }

    /**
     * DELETE
     */
    public function destroy($dp_pembayaran, $detail_dp_pembayaran)
    {
        $detail = DetailDpPembayaran::findOrFail($detail_dp_pembayaran);

        if ($detail->gambar) {
            Storage::disk('public')->delete($detail->gambar);
        }

        $detail->delete();

        // 🔥 TOTAL TERBARU
        $total = DetailDpPembayaran::where('dp_pembayaran_id', $dp_pembayaran)
            ->sum('jumlah');

        return response()->json([
            'success' => true,
            'message' => 'Detail pembayaran berhasil dihapus!',
            'total'   => $total
        ]);
    }
}