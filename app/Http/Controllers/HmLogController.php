<?php

namespace App\Http\Controllers;

use App\Models\HmLog;
use App\Models\TransaksiSewa;
use Illuminate\Http\Request;

class HmLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = HmLog::with('transaksi')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('hm_log.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $transaksi = TransaksiSewa::orderBy('id')->get();
        return view('hm_log.create', compact('transaksi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'transaksi_sewa_id' => 'required|exists:transaksi_sewas,id',
            'tanggal_terakhir'  => 'required|date',
            'tanggal_sekarang'  => 'required|date',
            'hm_terkahir'       => 'required|integer|min:0',
            'hm_sekarang'       => 'required|integer|min:0'
        ]);

        HmLog::create($validated);

        return redirect()->route('hm.index')
            ->with('success', 'HM Log berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = HmLog::findOrFail($id);
        $transaksi = TransaksiSewa::orderBy('id')->get();

        return view('hm_log.edit', compact('data', 'transaksi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $hm = HmLog::findOrFail($id);

        $validated = $request->validate([
            'transaksi_sewa_id' => 'required|exists:transaksi_sewas,id',
            'tanggal_terakhir'  => 'required|date',
            'tanggal_sekarang'  => 'required|date',
            'hm_terkahir'       => 'required|integer|min:0',
            'hm_sekarang'       => 'required|integer|min:0'
        ]);

        $hm->update($validated);

        return redirect()->route('hm.index')
            ->with('success', 'HM Log berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $hm = HmLog::findOrFail($id);
        $hm->delete();

        return redirect()->route('hm.index')
            ->with('success', 'HM Log berhasil dihapus.');
    }
}
