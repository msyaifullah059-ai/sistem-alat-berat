@extends('admin')

@section('title', 'Pricing')

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
                        <h6 class="card-title">Data Pelanggan</h6>
                        <button type="button" class="btn btn-primary btn-icon-text btn-xs mb-3" data-bs-toggle="modal"
                            data-bs-target="#createModal">
                            <i class="btn-icon-prepend" data-lucide="plus-circle"></i>
                            Tambah Data
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table id="dataPricing" class="table mb-3">
                            <thead>
                                <tr>
                                    <th>Alat Berat</th>
                                    <th>Jenis Pekerjaan</th>
                                    <th>Harga/Hari</th>
                                    <th>Harga/Jam</th>
                                    <th>Berlaku Mulai</th>
                                    <th>Berlaku Selesai</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('pricing.create')
    @include('pricing.edit')
@endsection

@section('scripts')
    <script>
        var table; // Wajib global

        $(document).ready(function() {
            // 1. Inisialisasi DataTables
            table = $('#dataPricing').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('pricing.index') }}",
                columns: [{
                        data: 'alat.nama_alat', // 'alat' itu nama function relasi di Model, 'nama_alat' itu kolom di tabel alat_berats
                        name: 'alat.nama_alat'
                    },
                    {
                        data: 'jenis_pekerjaan',
                        name: 'jenis_pekerjaan',
                        className: 'text-capitalize'
                    },
                    {
                        data: 'harga_per_hari',
                        name: 'harga_per_hari',
                        render: function(data, type, row) {
                            return formatRupiah(data);
                        }
                    },
                    {
                        data: 'harga_per_jam',
                        name: 'harga_per_jam',
                        render: function(data, type, row) {
                            return formatRupiah(data);
                        }
                    },
                    {
                        data: 'berlaku_mulai',
                        name: 'berlaku_mulai',
                        render: function(data) {
                            if (!data) return '-';
                            let d = new Date(data);
                            return d.toLocaleDateString('id-ID'); // Hasil: 19/3/2026
                        }
                    },
                    {
                        data: 'berlaku_selesai',
                        name: 'berlaku_selesai',
                        render: function(data) {
                            if (!data) return '-';
                            let d = new Date(data);
                            return d.toLocaleDateString('id-ID'); // Hasil: 19/3/2026
                        }
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
        function editPricing(id) {
            $.get("/pricing/" + id + "/edit", function(data) {
                // Set Action URL Form Edit
                $('#formEdit').attr('action', '/pricing/' + id);

                // Masukin data ke Inputan Modal Edit
                $('#edit_alat_berat_id').val(data.pricing.alat_berat_id);
                $('#edit_jenis_pekerjaan').val(data.pricing.jenis_pekerjaan);
                $('#edit_harga_per_hari').val(data.pricing.harga_per_hari);
                $('#edit_harga_per_jam').val(data.pricing.harga_per_jam);
                $('#edit_berlaku_mulai').val(data.pricing.berlaku_mulai);
                $('#edit_berlaku_selesai').val(data.pricing.berlaku_selesai);

                // Munculkan Modal
                $('#editModal').modal('show');
            }).fail(function() {
                Swal.fire("Error", "Gagal mengambil data", "error");
            });
        }

        // FUNGSI DELETE: Panggil fungsi global di admin.blade.php
        function deletePricing(id) {
            globalDelete(id, "/pricing/" + id, "Pricing");
        }
    </script>
@endsection
