<?php

namespace App\Http\Controllers;

use App\Models\About;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;

class AboutController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = About::query(); 
            
            return DataTables::of($data)
                ->addColumn('action', function($row){
                    $btn = '<button type="button" onclick="editAbout(\''.$row->id.'\')" class="btn btn-primary btn-icon btn-xs">
                <i class="mdi mdi-lead-pencil"></i>
            </button> ';
    
                    $btn .= '<button type="button" onclick="deleteAbout(\''.$row->id.'\')" class="btn btn-danger btn-icon btn-xs">
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
                // JANGAN LUPA: Tambahkan 'gambar' di dalam array rawColumns
                ->rawColumns(['action', 'gambar']) 
                ->make(true);
        }

        return view('about.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'deskripsi' => 'required',
            'gambar'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('about', 'public');
        }

        $about = About::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data tentang kita berhasil ditambahkan!'
        ]);
    }

    public function edit($id)
    {
        $about = About::findOrFail($id);
        return response()->json([
            'about' => $about
        ]);  // Balikin data dalam bentuk JSON
    }

    public function update(Request $request, $id)
    {
        // Cari datanya dulu
        $about = About::findOrFail($id);
        
        $validated = $request->validate([
            // Tambahkan .$id di akhir validasi unique
            'deskripsi' => 'required|unique:abouts,deskripsi,' . $id,
            'gambar'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($request->hasFile('gambar')) {
            // Opsi: Hapus gambar lama kalau mau hemat storage
            // if($alat->gambar) Storage::disk('public')->delete($alat->gambar);
            
            $validated['gambar'] = $request->file('gambar')->store('about', 'public');
        }

        $about->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data tentang kita berhasil diupdate!'
        ]);
    }

    public function destroy($id)
    {
        $about = About::findOrFail($id);

        // 1. Cek kalau ada gambar, hapus dari storage
        if ($about->gambar) {
            Storage::disk('public')->delete($about->gambar);
        }

        // 2. Hapus data dari database
        $about->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data tentang kita dan fotonya berhasil dihapus!'
        ]);
    }
}
