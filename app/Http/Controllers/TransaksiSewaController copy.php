<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf; // Taruh di paling atas file
use App\Models\Operator;
use App\Models\AlatBerat;
use App\Models\Pelanggan;
use App\Models\PricingAlat;
use App\Models\LokasiProyek;
use Illuminate\Http\Request;
use App\Models\TransaksiSewa;
use Yajra\DataTables\Facades\DataTables;

class TransaksiSewaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // PENTING: Tambahkan select agar status tidak tertukar dengan status alat
            $data = TransaksiSewa::with(['alat', 'operator', 'pelanggan'])
                    ->select('transaksi_sewas.*');

            // Logic Filter Berdasarkan Status
            if ($request->filled('status')) {
                $data->where('transaksi_sewas.status', $request->status);
            } else {
                // Jika belum pilih status, tabel kosong
                $data->where('transaksi_sewas.id', 0);
            }

            return DataTables::of($data)
                ->addColumn('action', function($row){
                    $btn = '<button type="button" onclick="editTransaksi(\''.$row->id.'\')" class="btn btn-primary btn-icon btn-xs">
                                <i class="mdi mdi-lead-pencil"></i>
                            </button> ';
                    $btn .= '<button type="button" onclick="detailTransaksi(\''.$row->id.'\')" class="btn btn-info btn-icon btn-xs text-white" title="Detail">
                                <i class="mdi mdi-eye"></i>
                            </button>';
                    $btn .= '&nbsp;<button type="button" onclick="deleteTransaksi(\''.$row->id.'\')" class="btn btn-danger btn-icon btn-xs">
                                <i class="mdi mdi-delete"></i>
                            </button>';
                    return $btn;
                })
                ->editColumn('status', function($row){
                    $val = strtolower($row->status);
                    $class = $val == 'berjalan' ? 'bg-warning' : ($val == 'selesai' ? 'bg-success' : 'bg-danger');
                    return '<span class="badge '.$class.'">'.ucfirst($val).'</span>';
                })
                ->rawColumns(['action', 'status']) 
                ->make(true);
        }

        $alat = AlatBerat::orderBy('nama_alat')->get();
        $pelanggan = Pelanggan::orderBy('nama')->get();
        $operator = Operator::orderBy('nama')->get();

        return view('transaksi.index', compact('alat', 'pelanggan', 'operator'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $alat = AlatBerat::all();
        $operator = Operator::all();
        $pelanggan = Pelanggan::all();

        return view('transaksi.create', compact('alat', 'operator', 'pelanggan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'alat_berat_id'   => 'required|exists:alat_berats,id',
            'operator_id'     => 'required|exists:operators,id',
            'pelanggan_id'    => 'required|exists:pelanggans,id',
            'jenis_sewa'      => 'required',
            'jenis_pekerjaan' => 'required|array|min:1',
            'jenis_pekerjaan.*' => 'in:baket,breker',
            'lokasi_proyek'   => 'required',
            'mobilisasi'      => 'required',
            'demobilisasi'    => 'required',
            'biaya_modem'     => 'nullable|integer|min:0',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date',
            'harga_sewa_baket' => 'nullable|integer|min:0',
            'harga_sewa_breker'  => 'nullable|integer|min:0',
            'status'          => 'required|in:berjalan,selesai,batal',
        ]);

        TransaksiSewa::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Transaksi berhasil ditambahkan!'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // WAJIB pake with() biar data nama pelanggan/alat/operator ikut kebawa ke JSON
        $transaksi = TransaksiSewa::with(['pelanggan', 'alat', 'operator'])->find($id);

        return response()->json([
            'transaksi' => $transaksi
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $transaksi = TransaksiSewa::findOrFail($id);

        $validated = $request->validate([
            'alat_berat_id'   => 'required|exists:alat_berats,id',
            'operator_id'     => 'required|exists:operators,id',
            'pelanggan_id'    => 'required|exists:pelanggans,id',
            'jenis_sewa'      => 'required',
            'jenis_pekerjaan' => 'required|array|min:1',
            'jenis_pekerjaan.*' => 'in:baket,breker',
            'lokasi_proyek'   => 'required',
            'mobilisasi'      => 'required',
            'demobilisasi'    => 'required',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date',
            'harga_sewa_baket' => 'nullable|integer|min:0',
            'harga_sewa_breker'  => 'nullable|integer|min:0',
            'status'          => 'required|in:berjalan,selesai,batal',
        ]);

        $transaksi->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Transaksi berhasil diupdate!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $transaksi = TransaksiSewa::findOrFail($id);
        $transaksi->delete();

        return response()->json([
            'success' => true,
            'message' => 'Transaksi sewa berhasil dihapus!'
        ]);
    }

    // CETAK SURAT JALAN (Fokus ke Logistik)
    public function printSuratJalan($id)
    {
        $transaksi = TransaksiSewa::with(['pelanggan', 'alat', 'operator'])->findOrFail($id);
        $pdf = Pdf::loadView('transaksi.surat_jalan', compact('transaksi'))->setPaper('a4', 'portrait');
        return $pdf->stream('Surat_Jalan_'.$transaksi->id.'.pdf');
    }

    // CETAK INVOICE (Fokus ke Penagihan/Duit)
    public function printInvoice($id)
    {
        $transaksi = TransaksiSewa::with(['pelanggan', 'alat'])->findOrFail($id);

        // Logic Smart ID: Ambil tahun & bulan dari tanggal dibuat
        $tahun = $transaksi->created_at->format('Y');
        $bulan = $transaksi->created_at->format('m');
        $paddedId = str_pad($transaksi->id, 4, '0', STR_PAD_LEFT);
        
        $no_invoice = "INV/$tahun/$bulan/$paddedId";
        
        // Kita "cast" atau paksa ke (int) biar kalau ada null/string kosong berubah jadi 0
        $total = $transaksi->harga_sewa_baket + 
                $transaksi->harga_sewa_breker + 
                $transaksi->biaya_modem; // Tambahin ini juga kalau ada

        $pdf = Pdf::loadView('transaksi.invoice', compact('transaksi', 'total'))->setPaper('a4', 'portrait');
        
        $namaFile = str_replace('/', '_', $no_invoice) . '_' . str_replace(' ', '_', $transaksi->pelanggan->nama) . '.pdf';
        return $pdf->stream($namaFile);
    }
}
