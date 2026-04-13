@extends('admin')

@section('title', 'Timesheet')

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
                        <h6 class="card-title">Data Timesheet</h6>
                        <button type="button" class="btn btn-primary btn-icon-text btn-xs mb-3" data-bs-toggle="modal"
                            data-bs-target="#createModal">
                            <i class="btn-icon-prepend" data-lucide="plus-circle"></i>
                            Tambah Data
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table id="datatimesheet" class="table mb-3">
                            <thead>
                                <tr>
                                    <th>Alat Berat</th>
                                    <th>Transaksi</th>
                                    <th>Tanggal</th>
                                    <th>Jam baket</th>
                                    <th>Jam breker</th>
                                    <th>HM Awal</th>
                                    <th>HM Akhir</th>
                                    <th>Tanggal Awal</th>
                                    <th>Tanggal Akhir</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('timesheet.create')
    @include('timesheet.edit')
@endsection

@section('scripts')
    <script>
        var table; // Wajib global

        $(document).ready(function() {
            // 1. Inisialisasi DataTables
            table = $('#datatimesheet').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('timesheet.index') }}",
                columns: [{
                        // FIX 2: Akses alat harus lewat transaksi
                        data: 'transaksi.alat.nama_alat',
                        name: 'transaksi.alat.nama_alat',
                    },
                    {
                        data: 'transaksi.pelanggan.nama',
                        name: 'transaksi.pelanggan.nama',
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal',
                        render: function(data) {
                            if (!data) return '-';
                            let d = new Date(data);
                            return d.toLocaleDateString('id-ID'); // Hasil: 19/3/2026
                        }
                    },
                    {
                        data: 'jam_baket',
                        name: 'jam_baket'
                    },
                    {
                        data: 'jam_breker',
                        name: 'jam_breker'
                    },
                    {
                        data: 'hm_awal',
                        name: 'hm_awal'
                    },
                    {
                        data: 'hm_akhir',
                        name: 'hm_akhir'
                    },
                    {
                        data: 'tanggal_awal_hm',
                        name: 'tanggal_awal_hm',
                        render: function(data) {
                            if (!data) return '-';
                            let d = new Date(data);
                            return d.toLocaleDateString('id-ID'); // Hasil: 19/3/2026
                        }
                    },
                    {
                        data: 'tanggal_akhir_hm',
                        name: 'tanggal_akhir_hm',
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
        function editTimesheet(id) {
            $.get("/timesheet/" + id + "/edit", function(data) {
                // Set Action URL Form Edit (pastiin route-nya bener)
                $('#formEdit').attr('action', '/timesheet/' + id);

                // Masukin data ke Inputan Modal Edit
                let ts = data.timesheet;
                let trans = ts.transaksi; // Ambil relasi transaksinya biar rapi

                // Pakai ID yang sesuai dengan HTML lu: #edit_transaksi_display
                let displayTeks = (trans?.pelanggan?.nama ?? '-') + ' | ' + (trans?.alat?.nama_alat ?? '-');
                $('#edit_transaksi_display').val(displayTeks);

                // Jangan lupa isi hidden inputnya supaya pas di-submit, 
                // Controller tau data mana yang lagi di-update
                $('#edit_transaksi_sewa_id').val(ts.transaksi_sewa_id);

                // Data Utama
                $('#edit_tanggal_kerja').val(ts.tanggal);
                $('#edit_tanggal_awal_hm').val(ts.tanggal_awal_hm);
                $('#edit_tanggal_akhir_hm').val(ts.tanggal_akhir_hm);
                $('#edit_hm_awal').val(ts.hm_awal);
                $('#edit_hm_akhir').val(ts.hm_akhir);
                $('#edit_jam_baket').val(ts.jam_baket);
                $('#edit_jam_breker').val(ts.jam_breker);

                // Munculkan Modal
                $('#editModal').modal('show');
            }).fail(function() {
                Swal.fire("Error", "Gagal mengambil data", "error");
            });
        }

        // FUNGSI DELETE: Panggil fungsi global di admin.blade.php
        function deleteTimesheet(id) {
            globalDelete(id, "/timesheet/" + id, "Timesheet");
        }
    </script>
@endsection
