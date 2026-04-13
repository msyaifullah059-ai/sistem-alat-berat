@extends('layout')

@section('content')
<div class="container">
    <h3 class="mb-4">Tambah Lokasi Proyek</h3>

    <form action="{{ route('lokasi.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Nama Lokasi</label>
            <input type="text" name="nama_lokasi" class="form-control"
                   value="{{ old('nama_lokasi') }}" required>
            @error('nama_lokasi')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label>Kabupaten</label>
            <input type="text" name="kabupaten" class="form-control"
                   value="{{ old('kabupaten') }}">
        </div>

        <div class="mb-3">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control" rows="3">{{ old('alamat') }}</textarea>
        </div>

        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('lokasi.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
