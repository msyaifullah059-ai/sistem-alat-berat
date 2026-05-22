<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Service::all();
            
            return DataTables::of($data)
                ->addColumn('action', function($row){
                    $btn = '<button type="button" onclick="editService(\''.$row->id.'\')" class="btn btn-primary btn-icon btn-xs">
                <i class="mdi mdi-lead-pencil"></i>
            </button> ';
    
                    $btn .= '<button type="button" onclick="deleteService(\''.$row->id.'\')" class="btn btn-danger btn-icon btn-xs">
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

        return view('service.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'gambar'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('service', 'public');
        }

        $alat = Service::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data Service berhasil ditambahkan!'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $service = Service::findOrFail($id);
        return response()->json([
            'service' => $service
        ]);  // Balikin data dalam bentuk JSON
    }

    public function update(Request $request, $id)
    {
        // Cari datanya dulu
        $service = Service::findOrFail($id);
        
        $validated = $request->validate([
            // Tambahkan .$id di akhir validasi unique
            'judul' => 'required|unique:services,judul,' . $id,
            'deskripsi' => 'required',
            'gambar'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($request->hasFile('gambar')) {
            
            $validated['gambar'] = $request->file('gambar')->store('service', 'public');
        }

        $service->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data Service berhasil diupdate!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $service = Service::findOrFail($id);

        // 1. Cek kalau ada gambar, hapus dari storage
        if ($service->gambar) {
            Storage::disk('public')->delete($service->gambar);
        }

        // 2. Hapus data dari database
        $service->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Service dan fotonya berhasil dihapus!'
        ]);
    }

}
