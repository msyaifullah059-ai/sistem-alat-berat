@extends('layout')

@section('content')
<div class="container">
    <h3 class="mb-4">Edit Lokasi Proyek</h3>

    <form action="{{ route('lokasi.update', $data->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nama Lokasi</label>
            <input type="text" name="nama_lokasi" class="form-control"
                   value="{{ old('nama_lokasi', $data->nama_lokasi) }}" required>
            @error('nama_lokasi')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label>Kabupaten</label>
            <input type="text" name="kabupaten" class="form-control"
                   value="{{ old('kabupaten', $data->kabupaten) }}">
        </div>

        <div class="mb-3">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control" rows="3">{{ old('alamat', $data->alamat) }}</textarea>
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('lokasi.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
