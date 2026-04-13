@extends('layout')

@section('content')
  <div class="container">

    <h4 class="mb-3">Data HM Log</h4>

    <a href="{{ route('hm.create') }}" class="btn btn-primary mb-3">+ Tambah HM Log</a>

    @if (session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>ID Transaksi</th>
          {{-- <th>Tanggal</th> --}}
          <th>HM Terakhir</th>
          <th>HM Sekarang</th>
          <th width="160px">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($data as $row)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>
              {{ $row->transaksi->pelanggan->nama ?? '-' }} -
              {{ $row->transaksi->alat->nama_alat ?? '-' }}
            </td>
            {{-- <td>{{ $row->tanggal }}</td> --}}
            <td>{{ $row->hm_terkahir }}</td>
            <td>{{ $row->hm_sekarang }}</td>
            <td>
              <a href="{{ route('hm.edit', $row->id) }}" class="btn btn-warning btn-sm">Edit</a>

              <form action="{{ route('hm.destroy', $row->id) }}" method="POST" class="d-inline"
                onsubmit="return confirm('Hapus data ini?')">
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
