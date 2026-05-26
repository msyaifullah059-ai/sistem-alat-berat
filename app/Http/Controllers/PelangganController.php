<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Pelanggan::query(); 
            
            return DataTables::of($data)
                ->addColumn('action', function($row){
                    $btn = '<button type="button" onclick="editPelanggan(\''.$row->id.'\')" class="btn btn-primary btn-icon btn-xs">
                <i class="mdi mdi-lead-pencil"></i>
            </button> ';
    
                    $btn .= '<button type="button" onclick="deletePelanggan(\''.$row->id.'\')" class="btn btn-danger btn-icon btn-xs">
                <i class="mdi mdi-delete"></i>
            </button>';
                    return $btn;
                })
                ->editColumn('ktp', function($row){
                    if ($row->ktp) {
                        $url = asset('storage/' . $row->ktp);
                        // Tambahin onclick buat panggil fungsi JS
                        return '<img src="'.$url.'" class="rounded shadow-sm" width="50" height="50" 
                                style="object-fit: cover; cursor: pointer;" 
                                onclick="showGambar(\''.$url.'\')">';
                    }
                    return '<small class="text-muted">No Image</small>';
                })
                // ---------------------------------------
                // ->editColumn('status', function($row){
                //     $class = $row->status == 'good' ? 'bg-success' : ($row->status == 'maintenance' ? 'bg-warning' : 'bg-danger');
                //     return '<span class="badge '.$class.'">'.ucfirst($row->status).'</span>';
                // })
                // JANGAN LUPA: Tambahkan 'gambar' di dalam array rawColumns
                ->rawColumns(['action', 'ktp']) 
                ->make(true);
        }

        return view('pelanggan.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     return view('pelanggan.create');
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'   => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'ktp'    => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($request->hasFile('ktp')) {
            $validated['ktp'] = $request->file('ktp')->store('pelanggan', 'public');
        }

        Pelanggan::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data Pelanggan berhasil ditambahkan!'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        return response()->json([
            'pelanggan' => $pelanggan
        ]); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        $validated = $request->validate([
            'nama'   => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'alamat' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'ktp'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($request->hasFile('ktp')) {
            // Opsi: Hapus gambar lama kalau mau hemat storage
            if($pelanggan->ktp) Storage::disk('public')->delete($pelanggan->ktp);
            
            $validated['ktp'] = $request->file('ktp')->store('pelanggan', 'public');
        }

        $pelanggan->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data Pelanggan berhasil diupdate!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        if ($pelanggan->ktp) {
            Storage::disk('public')->delete($pelanggan->ktp);
        }

        $pelanggan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Pelanggan berhasil dihapus!'
        ]);
    }
}
