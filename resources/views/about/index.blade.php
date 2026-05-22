@extends('admin')

@section('title', 'About')

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data About</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-row align-items-center justify-content-between border-bottom small mb-3">
                        <h6 class="card-title">Data About</h6>
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
                        <table id="dataAbout" class="table mb-3">
                            <thead>
                                <tr>
                                    <th>Deskripsi</th>
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

    @include('about.create')
    @include('about.edit')

@endsection

@section('scripts')
    <script>
        var table; // Wajib global

        $(document).ready(function() {
            // 1. Inisialisasi DataTables
            table = $('#dataAbout').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('about.index') }}",
                columns: [{
                        data: 'deskripsi',
                        name: 'deskripsi',
                        render: function(data, type, row) {
                            if (type === 'display') {
                                return `
                                    <div class="text-truncate" style="max-width:300px;" title="${data}">
                                        ${data}
                                    </div>
                                `;
                            }
                            return data;
                        }
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
        function editAbout(id) {
            $.get("/about/" + id + "/edit", function(data) {
                // Set Action URL Form Edit
                $('#formEditAbout').attr('action', '/about/' + id);

                // Masukin data ke Inputan Modal Edit
                $('#edit_deskripsi').val(data.about.deskripsi);

                // Tampilkan Gambar Lama jika ada
                if (data.about.gambar) {
                    $('#edit_previewGambar').attr('src', '/storage/' + data.about.gambar).show();
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
        function deleteAbout(id) {
            globalDelete(id, "/about/" + id, "About");
        }

        function showGambar(url) {
            // Tembak URL gambar ke modal
            $('#imgPreviewGede').attr('src', url);
            // Munculin modalnya
            $('#modalGambar').modal('show');
        }
    </script>
@endsection
