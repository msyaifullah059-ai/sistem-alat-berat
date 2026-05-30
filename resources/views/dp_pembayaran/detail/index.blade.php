@extends('admin')

@section('title', 'Detail Pembayaran')

@section('content')

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('dp_pembayaran.index') }}">Pembayaran</a></li>
            <li class="breadcrumb-item active">Detail Pembayaran</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    {{-- HEADER --}}
                    <div class="d-flex flex-row align-items-center justify-content-between border-bottom small mb-3">

                        <div>
                            <h6 class="card-title mb-1">Detail Pembayaran</h6>
                            <small class="text-muted">
                                {{ $pembayaran->transaksi->pelanggan->nama ?? '-' }}
                                -
                                {{ $pembayaran->transaksi->alat->nama_alat ?? '-' }}
                            </small>
                        </div>

                        <button type="button" class="btn btn-primary btn-icon-text btn-xs" data-bs-toggle="modal"
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

                    {{-- INFO --}}
                    <div class="row mb-3">

                        <div class="col-md-4">
                            <div class="border rounded p-3">
                                <small class="text-muted d-block">Lokasi Proyek</small>
                                <strong>{{ $pembayaran->transaksi->lokasi_proyek ?? '-' }}</strong>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="border rounded p-3">
                                <small class="text-muted d-block">Status</small>

                                @php
                                    $badge = $pembayaran->status == 'Lunas' ? 'bg-success' : 'bg-danger';
                                @endphp

                                <span class="badge {{ $badge }}">
                                    {{ $pembayaran->status }}
                                </span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="border rounded p-3">
                                <small class="text-muted d-block">Total Pembayaran</small>

                                <strong id="totalPembayaran">
                                    Rp {{ number_format($jumlah, 0, ',', '.') }}
                                </strong>
                            </div>
                        </div>

                    </div>

                    {{-- TABLE --}}
                    <div class="table-responsive">
                        <table id="dataPembayaran" class="table table-hover mb-3">
                            <thead>
                                <tr>
                                    <th>Tanggal Bayar</th>
                                    <th>Jumlah</th>
                                    <th>Keterangan</th>
                                    <th>Bukti Pembayaran</th>
                                    <th width="120">Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @include('dp_pembayaran.detail.create')
    @include('dp_pembayaran.detail.edit')

@endsection

@section('scripts')

    <script>
        /* =========================
                                           CSRF FIX (WAJIB - FIX 403)
                                        ========================= */
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table;

        $(document).ready(function() {

            /* =========================
               DATATABLE
            ========================= */
            table = $('#dataPembayaran').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('dp_pembayaran.detail_dp_pembayaran.index', $pembayaran->id) }}",
                    cache: false
                },
                columns: [{
                        data: 'tanggal_bayar',
                        name: 'tanggal_bayar'
                    },
                    {
                        data: 'jumlah',
                        name: 'jumlah'
                    },
                    {
                        data: 'keterangan',
                        name: 'keterangan'
                    },
                    {
                        data: 'gambar',
                        name: 'gambar',
                        orderable: false,
                        searchable: false
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

            /* =========================
               CREATE
            ========================= */
            let isSubmittingCreate = false;

            $(document).on('submit', '#formTambah', function(e) {

                e.preventDefault();

                if (isSubmittingCreate) return;

                isSubmittingCreate = true;

                let btn = $(this).find('button[type="submit"]');

                btn.prop('disabled', true);

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: new FormData(this),
                    processData: false,
                    contentType: false,

                    success: function(response) {

                        $('#createModal').modal('hide');

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                            timer: 1500,
                            showConfirmButton: false
                        });

                        table.ajax.reload(function() {

                            if (response.total !== undefined) {
                                updateTotal(response.total);
                            }

                        }, false);

                        $('#formTambah')[0].reset();

                        btn.prop('disabled', false);

                        isSubmittingCreate = false;
                    },

                    error: function(xhr) {

                        console.log(xhr.responseText);

                        btn.prop('disabled', false);

                        isSubmittingCreate = false;

                        Swal.fire(
                            "Error",
                            "Gagal simpan data",
                            "error"
                        );
                    }
                });
            });

        });

        /* =========================
           UPDATE TOTAL FUNCTION
        ========================= */
        function updateTotal(total) {
            if (total === undefined || total === null) return;

            $('#totalPembayaran').text(
                'Rp ' + new Intl.NumberFormat('id-ID').format(total)
            );
        }

        /* =========================
           EDIT
        ========================= */
        function editDetail(id) {

            $.get("/dp_pembayaran/{{ $pembayaran->id }}/detail_dp_pembayaran/" + id + "/edit",
                function(data) {

                    $('#formEdit').attr(
                        'action',
                        '/dp_pembayaran/{{ $pembayaran->id }}/detail_dp_pembayaran/' + id
                    );

                    $('#edit_tanggal_bayar').val(data.tanggal_bayar);
                    $('#edit_jumlah').val(data.jumlah);
                    $('#edit_keterangan').val(data.keterangan);

                    if (data.gambar) {
                        $('#edit_previewGambar')
                            .attr('src', '/storage/' + data.gambar)
                            .show();
                    } else {
                        $('#edit_previewGambar').hide();
                    }

                    $('#editModal').modal('show');
                }
            );
        }

        /* =========================
           UPDATE
        ========================= */
        let isSubmittingEdit = false;

        $(document).on('submit', '#formEdit', function(e) {

            e.preventDefault();

            if (isSubmittingEdit) return;

            isSubmittingEdit = true;

            let btn = $(this).find('button[type="submit"]');

            btn.prop('disabled', true);

            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,

                success: function(response) {

                    $('#editModal').modal('hide');

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false
                    });

                    table.ajax.reload(function() {

                        if (response.total !== undefined) {
                            updateTotal(response.total);
                        }

                    }, false);

                    btn.prop('disabled', false);

                    isSubmittingEdit = false;
                },

                error: function() {

                    btn.prop('disabled', false);

                    isSubmittingEdit = false;

                    Swal.fire(
                        "Error",
                        "Gagal update data",
                        "error"
                    );
                }
            });
        });

        /* =========================
           DELETE
        ========================= */
        function deleteDetail(dpId, detailId) {

            $.ajax({
                url: '/dp_pembayaran/' + dpId + '/detail_dp_pembayaran/' + detailId,
                type: 'DELETE',
                data: {
                    _token: "{{ csrf_token() }}"
                },

                success: function(response) {

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false
                    });

                    table.ajax.reload(function() {

                        if (response.total !== undefined) {

                            updateTotal(response.total);
                        }

                    }, false);
                },

                error: function(xhr) {
                    console.log(xhr.responseText);
                    Swal.fire("Error", "Gagal hapus data", "error");
                }
            });
        }

        /* =========================
           SHOW IMAGE
        ========================= */
        function showGambar(url) {
            $('#imgPreviewGede').attr('src', url);
            $('#modalGambar').modal('show');
        }
    </script>

@endsection
