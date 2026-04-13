@extends('admin')

@section('title', 'Operator')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Operator</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-row align-items-center justify-content-between border-bottom small mb-3">
                        <h6 class="card-title">Data Operator</h6>
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
                        <table id="dataOperator" class="table mb-3">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Kontak</th>
                                    <th>Alamat</th>
                                    <th>KTP</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('operator.create')
    @include('operator.edit')
@endsection

@section('scripts')
    <script>
        var table; // Wajib global

        $(document).ready(function() {
            // 1. Inisialisasi DataTables
            table = $('#dataOperator').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('operator.index') }}",
                columns: [{
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'no_hp',
                        name: 'no_hp',
                        render: function(data) {
                            if (!data) return '<span class="text-muted">-</span>';

                            // Contoh: Ubah 081234567890 jadi 0812-3456-7890
                            return data.replace(/(\d{4})(\d{4})(\d{4})/, '$1-$2-$3');
                        }
                    },
                    {
                        data: 'alamat',
                        name: 'alamat'
                    },
                    {
                        data: 'ktp',
                        name: 'ktp'
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
            $('#ktp').change(function() {
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
        function editOperator(id) {
            $.get("/operator/" + id + "/edit", function(data) {
                // Set Action URL Form Edit
                $('#formEdit').attr('action', '/operator/' + id);

                // Masukin data ke Inputan Modal Edit
                $('#edit_nama').val(data.operator.nama);
                $('#edit_no_hp').val(data.operator.no_hp);
                $('#edit_alamat').val(data.operator.alamat);

                // Tampilkan Gambar Lama jika ada
                if (data.operator.ktp) {
                    $('#edit_previewGambar').attr('src', '/storage/' + data.operator.ktp).show();
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
        function deleteOperator(id) {
            globalDelete(id, "/operator/" + id, "Operator");
        }

        function showGambar(url) {
            // Tembak URL gambar ke modal
            $('#imgPreviewGede').attr('src', url);
            // Munculin modalnya
            $('#modalGambar').modal('show');
        }
    </script>
@endsection
