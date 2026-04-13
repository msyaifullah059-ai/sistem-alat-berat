<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\AlatBerat;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AlatBeratController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = AlatBerat::query(); 
            
            return DataTables::of($data)
                ->addColumn('action', function($row){
                    $btn = '<button type="button" onclick="editAlat(\''.$row->id.'\')" class="btn btn-primary btn-icon btn-xs">
                <i class="mdi mdi-lead-pencil"></i>
            </button> ';
    
                    $btn .= '<button type="button" onclick="deleteAlat(\''.$row->id.'\')" class="btn btn-danger btn-icon btn-xs">
                                <i class="mdi mdi-delete"></i>
            </button>';
                    return $btn;
                })
                // --- TAMBAHKAN BAGIAN GAMBAR DI SINI ---
                ->editColumn('gambar', function($row){
                    if ($row->gambar) {
                        $url = asset('storage/' . $row->gambar);
                        // Tambahin onclick buat panggil fungsi JS
                        return '<img src="'.$url.'" class="rounded shadow-sm" width="50" height="50" 
                                style="object-fit: cover; cursor: pointer;" 
                                onclick="showGambar(\''.$url.'\')">';
                    }
                    return '<small class="text-muted">No Image</small>';
                })
                // ---------------------------------------
                ->editColumn('status', function($row){
                    $class = $row->status == 'good' ? 'bg-success' : ($row->status == 'maintenance' ? 'bg-warning' : 'bg-danger');
                    return '<span class="badge '.$class.'">'.ucfirst($row->status).'</span>';
                })
                // JANGAN LUPA: Tambahkan 'gambar' di dalam array rawColumns
                ->rawColumns(['action', 'status', 'gambar']) 
                ->make(true);
        }

        return view('alat.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     return view('alat.create');
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_unit' => 'required|unique:alat_berats,kode_unit',
            'nama_alat' => 'required',
            'jenis'     => 'required',
            'merk'      => 'nullable',
            'tahun'     => 'nullable|integer',
            'status'    => 'required|in:good,maintenance,broken',
            'gambar'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('alat', 'public');
        }

        $alat = AlatBerat::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data Alat Berat berhasil ditambahkan!'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $alat = AlatBerat::findOrFail($id);
        return response()->json([
            'alat' => $alat
        ]);  // Balikin data dalam bentuk JSON
    }

    public function update(Request $request, $id)
    {
        // Cari datanya dulu
        $alat = AlatBerat::findOrFail($id);
        
        $validated = $request->validate([
            // Tambahkan .$id di akhir validasi unique
            'kode_unit' => 'required|unique:alat_berats,kode_unit,' . $id,
            'nama_alat' => 'required',
            'jenis'     => 'required',
            'merk'      => 'nullable',
            'tahun'     => 'nullable|integer',
            'status'    => 'required|in:good,maintenance,broken',
            'gambar'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($request->hasFile('gambar')) {
            // Opsi: Hapus gambar lama kalau mau hemat storage
            // if($alat->gambar) Storage::disk('public')->delete($alat->gambar);
            
            $validated['gambar'] = $request->file('gambar')->store('alat', 'public');
        }

        $alat->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data Alat Berat berhasil diupdate!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $alat = AlatBerat::findOrFail($id);

        // 1. Cek kalau ada gambar, hapus dari storage
        if ($alat->gambar) {
            Storage::disk('public')->delete($alat->gambar);
        }

        // 2. Hapus data dari database
        $alat->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Alat Berat dan fotonya berhasil dihapus!'
        ]);
    }
}
