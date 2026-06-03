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
                                    <th>Transaksi Sewa</th>
                                    <th>Jenis Sewa & Lokasi</th>
                                    <th>Periode Sewa</th>
                                    <th>Status</th>
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
                        data: 'pelanggan_alat',
                        name: 'pelanggan_alat'
                    },
                    {
                        data: 'sewa_lokasi',
                        name: 'sewa_lokasi'
                    },
                    {
                        data: 'periode_sewa',
                        name: 'periode_sewa'
                    },
                    {
                        data: 'status',
                        name: 'status'
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

                $('#edit_transaksi_sewa_id').val(data.transaksi_sewa_id);
                $('#edit_status').val(data.status);

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

        function detailTimesheet(id) {
            window.location.href =
                "{{ url('timesheet') }}/" + id + "/detail_timesheet";
        }
    </script>
@endsection
