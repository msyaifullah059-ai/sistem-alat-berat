<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Operator;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class OperatorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Operator::query(); 
            
            return DataTables::of($data)
                ->addColumn('action', function($row){
                    $btn = '<button type="button" onclick="editOperator(\''.$row->id.'\')" class="btn btn-primary btn-icon btn-xs">
                <i class="mdi mdi-lead-pencil"></i>
            </button> ';
    
                    $btn .= '<button type="button" onclick="deleteOperator(\''.$row->id.'\')" class="btn btn-danger btn-icon btn-xs">
                <i class="mdi mdi-delete"></i>
            </button>';
                    return $btn;
                })
                // --- TAMBAHKAN BAGIAN GAMBAR DI SINI ---
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

        return view('operator.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     return view('operator.create');
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'   => 'required|string|max:255',
            'no_hp'  => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'ktp'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($request->hasFile('ktp')) {
            $validated['ktp'] = $request->file('ktp')->store('operator', 'public');
        }

        Operator::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data Operator berhasil ditambahkan!'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $operator = Operator::findOrFail($id);
        return response()->json([
            'operator' => $operator
        ]); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $operator = Operator::findOrFail($id);

        $validated = $request->validate([
            'nama'   => 'required|string|max:255',
            'no_hp'  => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'ktp'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($request->hasFile('ktp')) {
            // Opsi: Hapus gambar lama kalau mau hemat storage
            // if($alat->gambar) Storage::disk('public')->delete($alat->gambar);
            
            $validated['ktp'] = $request->file('ktp')->store('operator', 'public');
        }

        $operator->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data Operator berhasil diupdate!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $operator = Operator::findOrFail($id);

        // 1. Cek kalau ada gambar, hapus dari storage
        if ($operator->ktp) {
            Storage::disk('public')->delete($operator->ktp);
        }

        // 2. Hapus data dari database
        $operator->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Operator berhasil dihapus!'
        ]);
    }
}
