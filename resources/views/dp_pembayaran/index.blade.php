@extends('admin')

@section('title', 'Pembayaran')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Master</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-row align-items-center justify-content-between border-bottom small mb-3">
                        <h6 class="card-title">Data Pembayaran</h6>
                        <button type="button" class="btn btn-primary btn-icon-text btn-xs mb-3" data-bs-toggle="modal"
                            data-bs-target="#createModal">
                            <i class="btn-icon-prepend" data-lucide="plus-circle"></i>
                            Tambah Data
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table id="dataPelanggan" class="table mb-3">
                            <thead>
                                <tr>
                                    <th>Transkasi Sewa</th>
                                    <th>Tanggal</th>
                                    <th>Jumlah</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('dp_pembayaran.create')
    @include('dp_pembayaran.edit')
@endsection

@section('scripts')
    <script>
        var table; // Wajib global

        $(document).ready(function() {
            // 1. Inisialisasi DataTables
            table = $('#dataPelanggan').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('dp_pembayaran.index') }}",
                columns: [{
                        data: 'pelanggan_alat',
                        name: 'pelanggan_alat'
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal'
                    },
                    {
                        data: 'jumlah',
                        name: 'jumlah',
                    },
                    {
                        data: 'keterangan',
                        name: 'keterangan'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });

        // FUNGSI EDIT: Narik data dari server & masukin ke modal
        function editdp_pembayaran(id) {
            $.get("/dp_pembayaran/" + id + "/edit", function(data) {
                // Set Action URL Form Edit
                $('#formEdit').attr('action', '/dp_pembayaran/' + id);

                $('#edit_transaksi_sewa_id').val(data.transaksi_sewa_id);
                $('#edit_tanggal').val(data.tanggal);
                $('#edit_jumlah').val(data.jumlah);
                $('#edit_keterangan').val(data.keterangan);

                // Munculkan Modal
                $('#editModal').modal('show');
            }).fail(function() {
                Swal.fire("Error", "Gagal mengambil data", "error");
            });
        }

        // FUNGSI DELETE: Panggil fungsi global di admin.blade.php
        function deletedp_pembayaran(id) {
            globalDelete(id, "/dp/" + id, "Dp Pembayaran");
        }
    </script>
@endsection
