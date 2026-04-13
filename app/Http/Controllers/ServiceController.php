<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Service::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $encodedId = base64_encode($row->id);

                    return '<a href="' . route('service.edit', $encodedId) . '" class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                <form action="' . route('service.delete', $row->id) . '" method="POST" style="display:inline;">
                    ' . csrf_field() . method_field('DELETE') . '
                    <button type="submit" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>
                </form>';
                })
                ->make(true);
        }

        return view('service.index');
    }

    public function add(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('gambar', 'public');
            $gambarPath = str_replace('public/', 'storage/', $gambarPath);
        }

        try {
            Service::create([
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'gambar' => $gambarPath,
            ]);

            Alert::success('Berhasil!', 'Tambah data berhasil!');
        } catch (\Exception $e) {
            Alert::error('Gagal!', 'Tambah data gagal.');
        }

        return redirect()->route('service.index');
    }

    public function edit(Request $request, $encoded_id)
    {
        $id = base64_decode($encoded_id);

        $service = Service::findOrFail($id);

        if ($request->isMethod('post')) {
            $request->validate([
                'judul' => 'required',
                'deskripsi' => 'required',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $gambarPath = $service->gambar;

            if ($request->hasFile('gambar')) {
                $gambarPath = $request->file('gambar')->store('gambar', 'public');
                $gambarPath = str_replace('public/', 'storage/', $gambarPath);
            }

            try {
                $service->update([
                    'judul' => $request->judul,
                    'deskripsi' => $request->deskripsi,
                    'gambar' => $gambarPath,
                ]);

                Alert::success('Berhasil!', 'Edit data berhasil!');
            } catch (\Exception $e) {
                Alert::error('Gagal!', 'Edit data gagal.');
            }

            return redirect()->route('service.index');
        }

        return view('service.edit', compact('service'));
    }

    public function destroy($id)
    {
        $service = Service::findOrFail($id);

        if ($service->gambar) {
            $gambarPath = str_replace('storage/', 'public/', $service->gambar);
            Storage::delete($gambarPath);
        }

        try {
            Service::destroy($id);

            Alert::success('Berhasil!', 'Hapus data berhasil!');
        } catch (\Exception $e) {
            Alert::error('Gagal!', 'Hapus data gagal!');
        }
        return redirect()->route('service.index');
    }

}
