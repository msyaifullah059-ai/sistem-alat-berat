<?php

namespace App\Http\Controllers;

use App\Models\PricingAlat;
use App\Models\AlatBerat;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables; // Jangan lupa import ini juga biar gak error DataTables!

class PricingAlatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = PricingAlat::with('alat')->get();
            
            return DataTables::of($data)
                ->addColumn('action', function($row){
                    $btn = '<button type="button" onclick="editPricing(\''.$row->id.'\')" class="btn btn-primary btn-icon btn-xs">
                                <i class="mdi mdi-lead-pencil"></i>
                            </button> ';
    
                    $btn .= '<button type="button" onclick="deletePricing(\''.$row->id.'\')" class="btn btn-danger btn-icon btn-xs">
                                <i class="mdi mdi-delete"></i>
                            </button>';
                    return $btn;
                })
                ->rawColumns(['action']) 
                ->make(true);
        }

        // PERBAIKAN: Tambahkan variabel alat di sini agar Modal Tambah di index.blade.php bisa pake @foreach
        $alat = AlatBerat::orderBy('nama_alat')->get();

        return view('pricing.index', compact('alat'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'alat_berat_id'    => 'required|exists:alat_berats,id',
            'jenis_pekerjaan'  => 'required|in:baket,breker',
            'harga_per_hari'   => 'nullable|integer',
            'harga_per_jam'    => 'nullable|integer',
            'berlaku_mulai'    => 'required|date',
            'berlaku_selesai'  => 'nullable|date|after_or_equal:berlaku_mulai',
        ]);

        PricingAlat::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data harga sewa berhasil ditambahkan!'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $pricing = PricingAlat::findOrFail($id);
        
        // PERBAIKAN: Format JSON yang benar untuk kirim beberapa data sekaligus
        return response()->json([
            'pricing' => $pricing
        ]); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $pricing = PricingAlat::findOrFail($id);

        $validated = $request->validate([
            'alat_berat_id'    => 'required|exists:alat_berats,id',
            'jenis_pekerjaan'  => 'required|in:baket,breker',
            'harga_per_hari'   => 'nullable|integer',
            'harga_per_jam'    => 'nullable|integer',
            'berlaku_mulai'    => 'required|date',
            'berlaku_selesai'  => 'nullable|date|after_or_equal:berlaku_mulai',
        ]);

        $pricing->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data harga sewa berhasil diupdate!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pricing = PricingAlat::findOrFail($id);
        $pricing->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data harga sewa berhasil dihapus!'
        ]);
    }
}