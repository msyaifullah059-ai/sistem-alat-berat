<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = User::query();

            return DataTables::of($data)

                ->addColumn('action', function ($row) {

                    $btn = '<button type="button" onclick="editUsers(\'' . $row->id . '\')" class="btn btn-primary btn-icon btn-xs">
                                <i class="mdi mdi-lead-pencil"></i>
                            </button> ';

                    $btn .= '<button type="button" onclick="deleteUsers(\'' . $row->id . '\')" class="btn btn-danger btn-icon btn-xs">
                                <i class="mdi mdi-delete"></i>
                             </button>';

                    return $btn;
                })

                ->editColumn('gambar', function ($row) {

                    if ($row->gambar) {

                        $url = asset('storage/' . $row->gambar);

                        return '<img src="' . $url . '" 
                                    class="rounded shadow-sm" 
                                    width="50" 
                                    height="50"
                                    style="object-fit: cover; cursor: pointer;"
                                    onclick="showGambar(\'' . $url . '\')">';
                    }

                    return '<small class="text-muted">No Image</small>';
                })

                ->editColumn('role', function ($row) {

                    if ($row->role == 'admin') {

                        return '<span class="badge bg-danger">
                                    Admin
                                </span>';
                    }

                    return '<span class="badge bg-primary">
                                Staff
                            </span>';
                })

                ->rawColumns([
                    'action',
                    'gambar',
                    'role'
                ])

                ->make(true);
        }

        return view('users.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'      => 'required|max:255',
            'email'     => 'required|email|unique:users,email',
            'role'      => 'required|in:admin,staff',
            'password'  => 'required|min:6',
            'gambar'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Upload gambar
        if ($request->hasFile('gambar')) {

            $validated['gambar'] = $request->file('gambar')
                ->store('users', 'public');
        }

        // Hash Password
        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'User berhasil ditambahkan!'
        ]);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        return response()->json([
            'user' => $user
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name'      => 'required|max:255',
            'email'     => 'required|email|unique:users,email,' . $id,
            'role'      => 'required|in:admin,staff',
            'password'  => 'nullable|min:6',
            'gambar'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Upload gambar Baru
        if ($request->hasFile('gambar')) {

            // Hapus gambar lama
            if ($user->gambar) {

                Storage::disk('public')
                    ->delete($user->gambar);
            }

            $validated['gambar'] = $request->file('gambar')
                ->store('users', 'public');
        }

        // Update Password jika diisi
        if (!empty($request->password)) {

            $validated['password'] = Hash::make($request->password);

        } else {

            unset($validated['password']);
        }

        $user->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'User berhasil diupdate!'
        ]);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Hapus gambar
        if ($user->gambar) {

            Storage::disk('public')
                ->delete($user->gambar);
        }

        // Hapus user
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User berhasil dihapus!'
        ]);
    }
}