@extends('layout')

@section('content')
<div class="container">
    <h3 class="mb-4">Data Lokasi Proyek</h3>

    <a href="{{ route('lokasi.create') }}" class="btn btn-primary mb-3">+ Tambah Lokasi</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Lokasi</th>
                <th>Kabupaten</th>
                <th>Alamat</th>
                <th width="160">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($data as $row)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $row->nama_lokasi }}</td>
                    <td>{{ $row->kabupaten ?? '-' }}</td>
                    <td>{{ $row->alamat ?? '-' }}</td>
                    <td>
                        <a href="{{ route('lokasi.edit', $row->id) }}"
                           class="btn btn-warning btn-sm">Edit</a>

                        <form action="{{ route('lokasi.destroy', $row->id) }}"
                              method="POST" class="d-inline"
                              onsubmit="return confirm('Yakin ingin menghapus?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>
</div>
@endsection
