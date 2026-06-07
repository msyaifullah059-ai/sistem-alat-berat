@extends('admin')

@section('title', 'Detail Timesheet')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <nav aria-label="breadcrumb">

        <ol class="breadcrumb">

            <li class="breadcrumb-item">
                <a href="{{ route('dashboard.index') }}">
                    Dashboard
                </a>
            </li>

            <li class="breadcrumb-item">
                <a href="{{ route('timesheet.index') }}">
                    Timesheet
                </a>
            </li>

            <li class="breadcrumb-item active">
                Detail Timesheet
            </li>

        </ol>

    </nav>

    <div class="row">

        <div class="col-md-12 grid-margin stretch-card">

            <div class="card">

                <div class="card-body">

                    {{-- HEADER --}}
                    <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">

                        <div>

                            <h6 class="card-title mb-1">

                                Detail Timesheet

                            </h6>

                            <small class="text-muted">

                                {{ $timesheet->transaksi->pelanggan->nama ?? '-' }}

                                -

                                {{ $timesheet->transaksi->alat->nama_alat ?? '-' }}

                            </small>

                        </div>

                        <div>

                            <a href="{{ route('timesheet.detail.export', $timesheet->transaksi_sewa_id) }}"
                                class="btn btn-success btn-icon-text btn-xs">

                                <i class="mdi mdi-file-excel"></i>
                                Export Excel
                            </a>

                            <button type="button" class="btn btn-primary btn-icon-text btn-xs" data-bs-toggle="modal"
                                data-bs-target="#createModal">

                                <i class="mdi mdi-plus-circle"></i>

                                Tambah Data

                            </button>

                        </div>

                    </div>

                    {{-- INFO --}}
                    <div class="row mb-4">

                        <div class="col-md-3 mb-2">

                            <div class="border rounded p-3">

                                <small class="text-muted d-block">
                                    Lokasi Proyek
                                </small>

                                <strong>

                                    {{ $timesheet->transaksi->lokasi_proyek ?? '-' }}

                                </strong>

                            </div>

                        </div>

                        <div class="col-md-3 mb-2">

                            <div class="border rounded p-3">

                                <small class="text-muted d-block">
                                    Status
                                </small>

                                @php
                                    $badge = $timesheet->status == 'Berjalan' ? 'bg-warning' : 'bg-success';
                                @endphp

                                <span class="badge {{ $badge }}">

                                    {{ $timesheet->status }}

                                </span>

                            </div>

                        </div>

                        <div class="col-md-3 mb-2">

                            <div class="border rounded p-3">

                                <small class="text-muted d-block">
                                    Total Jam Baket
                                </small>

                                <strong id="totalJamBaket">

                                    {{ number_format($totalJamBaket) }}

                                </strong>

                            </div>

                        </div>

                        <div class="col-md-3 mb-2">

                            <div class="border rounded p-3">

                                <small class="text-muted d-block">
                                    Total Jam Breker
                                </small>

                                <strong id="totalJamBreker">

                                    {{ number_format($totalJamBreker) }}

                                </strong>

                            </div>

                        </div>

                    </div>

                    {{-- TABLE --}}
                    <div class="table-responsive">

                        <table id="dataDetailTimesheet" class="table table-hover">

                            <thead>

                                <tr>

                                    <th>Tanggal Pekerjaan</th>
                                    <th>Jam Baket</th>
                                    <th>Jam Breker</th>
                                    <th>HM Awal</th>
                                    <th>HM Akhir</th>
                                    <th>Gambar</th>
                                    <th width="120">
                                        Aksi
                                    </th>

                                </tr>

                            </thead>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- MODAL PREVIEW GAMBAR --}}
    <div class="modal fade" id="modalGambar" tabindex="-1">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content bg-transparent border-0">

                <div class="modal-body text-center">

                    <img id="imgPreviewGede" class="img-fluid rounded shadow">

                </div>

            </div>

        </div>

    </div>

    {{-- MODAL --}}
    @include('timesheet.detail.create')
    @include('timesheet.detail.edit')
@endsection

@section('scripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let table;

        $(document).ready(function() {

            /* =========================
               DATATABLE
            ========================= */
            table = $('#dataDetailTimesheet').DataTable({

                processing: true,
                serverSide: true,

                ajax: {
                    url: "{{ route('timesheet.detail_timesheet.index', $timesheet->id) }}"
                },

                columns: [{
                        data: 'tanggal_pekerjaan',
                        name: 'tanggal_pekerjaan'
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

            /* =========================
               PREVIEW CREATE
            ========================= */
            $('#gambar').change(function() {

                const file = this.files[0];

                if (file) {

                    let reader = new FileReader();

                    reader.onload = function(e) {

                        $('#previewGambar')
                            .attr('src', e.target.result)
                            .show();

                    }

                    reader.readAsDataURL(file);
                }
            });

            /* =========================
               PREVIEW EDIT
            ========================= */
            $(document).on(
                'change',
                '#edit_gambar',
                function() {

                    const file = this.files[0];

                    if (file) {

                        let reader = new FileReader();

                        reader.onload = function(e) {

                            $('#edit_previewGambar')
                                .attr('src', e.target.result)
                                .show();

                        }

                        reader.readAsDataURL(file);
                    }
                }
            );

        });

        /* =========================
           UPDATE TOTAL
        ========================= */
        function updateTotalJam(
            totalJamBaket,
            totalJamBreker
        ) {

            $('#totalJamBaket').text(
                totalJamBaket
            );

            $('#totalJamBreker').text(
                totalJamBreker
            );
        }

        /* =========================
           CREATE
        ========================= */
        let isSubmittingCreate = false;

        $(document).on(
            'submit',
            '#formTambah',
            function(e) {

                e.preventDefault();

                if (isSubmittingCreate) return;

                isSubmittingCreate = true;

                let btn = $(this)
                    .find('button[type="submit"]');

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

                        table.ajax.reload(null, false);

                        updateTotalJam(
                            response.totalJamBaket,
                            response.totalJamBreker
                        );

                        $('#formTambah')[0].reset();

                        $('#previewGambar').hide();

                        btn.prop('disabled', false);

                        isSubmittingCreate = false;
                    },

                    error: function(xhr) {

                        console.log(xhr.responseText);

                        btn.prop('disabled', false);

                        isSubmittingCreate = false;

                        Swal.fire(
                            'Error',
                            'Gagal simpan data',
                            'error'
                        );
                    }
                });
            }
        );

        /* =========================
           EDIT
        ========================= */
        function editDetail(id) {

            $.get(

                "/timesheet/{{ $timesheet->id }}/detail_timesheet/" +
                id +
                "/edit",

                function(data) {

                    $('#formEdit').attr(
                        'action',
                        '/timesheet/{{ $timesheet->id }}/detail_timesheet/' +
                        id
                    );

                    $('#edit_tanggal_pekerjaan')
                        .val(data.tanggal_pekerjaan);

                    $('#edit_tanggal_awal_hm')
                        .val(data.tanggal_awal_hm);

                    $('#edit_tanggal_akhir_hm')
                        .val(data.tanggal_akhir_hm);

                    $('#edit_jam_baket')
                        .val(data.jam_baket);

                    $('#edit_hm_awal')
                        .val(data.hm_awal);

                    $('#edit_hm_akhir')
                        .val(data.hm_akhir);

                    $('#edit_jam_breker')
                        .val(data.jam_breker);

                    if (data.gambar) {

                        $('#edit_previewGambar')
                            .attr(
                                'src',
                                '/storage/' + data.gambar
                            )
                            .show();

                    } else {

                        $('#edit_previewGambar')
                            .hide();
                    }

                    $('#editModal')
                        .modal('show');
                }
            );
        }

        /* =========================
           UPDATE
        ========================= */
        let isSubmittingEdit = false;

        $(document).on(
            'submit',
            '#formEdit',
            function(e) {

                e.preventDefault();

                if (isSubmittingEdit) return;

                isSubmittingEdit = true;

                let btn = $(this)
                    .find('button[type="submit"]');

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

                        table.ajax.reload(null, false);

                        updateTotalJam(
                            response.totalJamBaket,
                            response.totalJamBreker
                        );

                        btn.prop('disabled', false);

                        isSubmittingEdit = false;
                    },

                    error: function() {

                        btn.prop('disabled', false);

                        isSubmittingEdit = false;

                        Swal.fire(
                            'Error',
                            'Gagal update data',
                            'error'
                        );
                    }
                });
            }
        );

        /* =========================
           DELETE
        ========================= */
        function deleteDetail(
            timesheetId,
            detailId
        ) {

            Swal.fire({

                title: 'Yakin?',

                text: 'Data akan dihapus',

                icon: 'warning',

                showCancelButton: true,

                confirmButtonText: 'Ya Hapus'

            }).then((result) => {

                if (result.isConfirmed) {

                    $.ajax({

                        url: '/timesheet/' +
                            timesheetId +
                            '/detail_timesheet/' +
                            detailId,

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

                            table.ajax.reload(null, false);

                            updateTotalJam(
                                response.totalJamBaket,
                                response.totalJamBreker
                            );
                        }
                    });
                }
            });
        }

        /* =========================
           SHOW IMAGE
        ========================= */
        function showGambar(url) {

            $('#imgPreviewGede')
                .attr('src', url);

            $('#modalGambar')
                .modal('show');
        }
    </script>
@endsection
