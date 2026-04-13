@extends('admin')

@section('title', 'Alat')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Alat</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-row align-items-center justify-content-between border-bottom small mb-3">
                        <h6 class="card-title">Data Alat</h6>
                        <button type="button" class="btn btn-primary btn-icon-text btn-xs mb-3" data-bs-toggle="modal"
                            data-bs-target="#createModal">
                            <i class="btn-icon-prepend" data-lucide="plus-circle"></i>
                            Tambah Data
                        </button>
                    </div>
                    <div class="modal fade" id="modalGambar" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content bg-transparent border-0">
                                <div class="modal-body text-center">
                                    <img src="" id="imgPreviewGede" class="img-fluid rounded shadow"
                                        style="max-height: 80vh;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="dataAlat" class="table mb-3">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Jenis</th>
                                    <th>Merk</th>
                                    <th>Tahun</th>
                                    <th>Status</th>
                                    <th>Gambar</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('alat.create')
    @include('alat.edit')
@endsection

@section('scripts')
    <script>
        var table; // Wajib global

        $(document).ready(function() {
            // 1. Inisialisasi DataTables
            table = $('#dataAlat').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('alat.index') }}",
                columns: [{
                        data: 'kode_unit',
                        name: 'kode_unit'
                    },
                    {
                        data: 'nama_alat',
                        name: 'nama_alat'
                    },
                    {
                        data: 'jenis',
                        name: 'jenis'
                    },
                    {
                        data: 'merk',
                        name: 'merk'
                    },
                    {
                        data: 'tahun',
                        name: 'tahun',
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'gambar',
                        name: 'gambar'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // 2. Preview Gambar Modal Create
            $('#gambar').change(function() {
                const file = this.files[0];
                if (file) {
                    let reader = new FileReader();
                    reader.onload = function(event) {
                        $('#previewGambar').attr('src', event.target.result).fadeIn();
                    };
                    reader.readAsDataURL(file);
                }
            });

            // 3. Preview Gambar Modal Edit
            $(document).on('change', '#edit_gambar', function() {
                const file = this.files[0];
                if (file) {
                    let reader = new FileReader();
                    reader.onload = function(event) {
                        $('#edit_previewGambar').attr('src', event.target.result).fadeIn();
                    };
                    reader.readAsDataURL(file);
                }
            });
        });

        // FUNGSI EDIT: Narik data dari server & masukin ke modal
        function editAlat(id) {
            $.get("/alat/" + id + "/edit", function(data) {
                // Set Action URL Form Edit
                $('#formEditAlat').attr('action', '/alat/' + id);

                // Masukin data ke Inputan Modal Edit
                $('#edit_kode_unit').val(data.alat.kode_unit);
                $('#edit_nama_alat').val(data.alat.nama_alat);
                $('#edit_jenis').val(data.alat.jenis);
                $('#edit_merk').val(data.alat.merk);
                $('#edit_tahun').val(data.alat.tahun);
                $('#edit_status').val(data.alat.status);

                // Tampilkan Gambar Lama jika ada
                if (data.alat.gambar) {
                    $('#edit_previewGambar').attr('src', '/storage/' + data.alat.gambar).show();
                } else {
                    $('#edit_previewGambar').hide();
                }

                // Munculkan Modal
                $('#editModal').modal('show');
            }).fail(function() {
                Swal.fire("Error", "Gagal mengambil data", "error");
            });
        }

        // FUNGSI DELETE: Panggil fungsi global di admin.blade.php
        function deleteAlat(id) {
            globalDelete(id, "/alat/" + id, "Alat Berat");
        }

        function showGambar(url) {
            // Tembak URL gambar ke modal
            $('#imgPreviewGede').attr('src', url);
            // Munculin modalnya
            $('#modalGambar').modal('show');
        }
    </script>
@endsection
