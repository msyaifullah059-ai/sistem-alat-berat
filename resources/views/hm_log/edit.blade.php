@extends('layout')

@section('content')
    <div class="container">

        <h4 class="mb-3">Edit HM Log</h4>

        <form action="{{ route('hm.update', $data->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Transaksi</label>
                <select name="transaksi_sewa_id" class="form-control" required>
                    @foreach ($transaksi as $t)
                        <option value="{{ $t->id }}" {{ $data->transaksi_sewa_id == $t->id ? 'selected' : '' }}>
                            {{ $t->id }} - {{ $t->pelanggan->nama ?? 'Pelanggan' }} /
                            {{ $t->alat->nama_alat ?? 'Alat' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Tanggal HM Terakhir</label>
                <input type="date" name="tanggal_terakhir" class="form-control" required
                    value="{{ old('tanggal_terakhir', $data->tanggal_terakhir) }}">
            </div>

            <div class="mb-3">
                <label>Tanggal HM Sekarang</label>
                <input type="date" name="tanggal_sekarang" class="form-control" required
                    value="{{ old('tanggal_sekarang', $data->tanggal_sekarang) }}">
            </div>

            <div class="mb-3">
                <label>HM Terakhir</label>
                <input type="number" name="hm_terkahir" class="form-control" required min="0"
                    value="{{ old('hm_terkahir', $data->hm) }}">
            </div>

            <div class="mb-3">
                <label>HM Sekarang</label>
                <input type="number" name="hm_sekarang" class="form-control" required min="0"
                    value="{{ old('hm_sekarang', $data->hm) }}">
            </div>

            <button class="btn btn-primary">Update</button>
            <a href="{{ route('hm.index') }}" class="btn btn-secondary">Kembali</a>

        </form>

    </div>
@endsection
