<?php

namespace App\Http\Controllers;

use App\Models\About;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\AboutImport;

class AboutController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = About::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $encodedId = base64_encode($row->id);

                    return '<a href="' . route('about.edit', $encodedId) . '" class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                <form action="' . route('about.delete', $row->id) . '" method="POST" style="display:inline;">
                    ' . csrf_field() . method_field('DELETE') . '
                    <button type="submit" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>
                </form>';
                })
                ->make(true);
        }

        return view('about.index');
    }

    public function add(Request $request)
    {
        $request->validate([
            'deskripsi' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('gambar', 'public');
            $gambarPath = str_replace('public/', 'storage/', $gambarPath);
        }

        try {
            About::create([
                'deskripsi' => $request->deskripsi,
                'gambar' => $gambarPath,
            ]);

            Alert::success('Berhasil!', 'Tambah data berhasil!');
        } catch (\Exception $e) {
            Alert::error('Gagal!', 'Tambah data gagal.');
        }

        return redirect()->route('about.index');
    }

    public function edit(Request $request, $encoded_id)
    {
        $id = base64_decode($encoded_id);

        $about = About::findOrFail($id);

        if ($request->isMethod('post')) {
            $request->validate([
                'deskripsi' => 'required',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $gambarPath = $about->gambar;

            if ($request->hasFile('gambar')) {
                $gambarPath = $request->file('gambar')->store('gambar', 'public');
                $gambarPath = str_replace('public/', 'storage/', $gambarPath);
            }

            try {
                $about->update([
                    'deskripsi' => $request->deskripsi,
                    'gambar' => $gambarPath,
                ]);

                Alert::success('Berhasil!', 'Edit data berhasil!');
            } catch (\Exception $e) {
                Alert::error('Gagal!', 'Edit data gagal.');
            }

            return redirect()->route('about.index');
        }

        return view('about.edit', compact('about'));
    }

    public function destroy($id)
    {
        $about = About::findOrFail($id);

        if ($about->gambar) {
            $gambarPath = str_replace('storage/', 'public/', $about->gambar);
            Storage::delete($gambarPath);
        }

        try {
            About::destroy($id);

            Alert::success('Berhasil!', 'Hapus data berhasil!');
        } catch (\Exception $e) {
            Alert::error('Gagal!', 'Hapus data gagal!');
        }

        return redirect()->route('about.index');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
        ]);

        try {
            Excel::import(new AboutImport, $request->file('file'));

            Alert::success('Berhasil!', 'Data berhasil diimpor!');
        } catch (\Exception $e) {
            Alert::error('Gagal!', 'Terjadi kesalahan saat mengimpor data.');
        }

        return redirect()->route('about.index');
    }
}
