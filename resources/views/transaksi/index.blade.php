@extends('admin')

@section('title', 'Transaksi')

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
                    <hr>
                    <div id="containerTable">
                        <div class="d-flex flex-row align-items-center justify-content-between border-bottom pb-3 mb-3">
                            <h6 class="card-title mb-0">Data Transaksi Sewa</h6>
                            <button type="button" class="btn btn-primary btn-icon-text btn-xs" data-bs-toggle="modal"
                                data-bs-target="#createModal">
                                <i class="btn-icon-prepend" data-lucide="plus-circle"></i> Tambah Data
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table id="dataTransaksi" class="table table-hover mb-3">
                                <thead>
                                    <tr>
                                        <th>Pelanggan</th>
                                        {{-- <th>Operator</th> --}}
                                        <th>Operator & Alat</th>
                                        <th>Jenis Sewa & Lokasi</th>
                                        <th>Harga Baket & Breker</th>
                                        <th>Periode Sewa</th>
                                        {{-- <th>Tgl Mulai</th>
                                        <th>Tgl Selesai</th> --}}
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
    </div>

    @include('transaksi.create')
    @include('transaksi.detail')
    @include('transaksi.edit')
@endsection

@section('scripts')
    <script>
        var table;

        $(document).ready(function() {

            // =========================
            // DATATABLE
            // =========================
            table = $('#dataTransaksi').DataTable({

                processing: true,

                serverSide: true,

                ajax: "{{ route('transaksi.index') }}",

                columns: [{
                        data: 'pelanggan.nama',
                        name: 'pelanggan.nama'
                    },

                    // {
                    //     data: 'operator.nama',
                    //     name: 'operator.nama'
                    // },

                    {
                        data: 'operator_alat',
                        name: 'operator_alat'
                    },

                    {
                        data: 'jenis_lokasi',
                        name: 'jenis_lokasi'
                    },
                    {
                        data: 'baket_breker',
                        name: 'baket_breker'
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

            // =========================
            // RESET MODAL CREATE
            // =========================
            $('#createModal').on('hidden.bs.modal', function() {

                $(this).find('form')[0].reset();

                $('#div_harga_baket').hide();

                $('#div_harga_breker').hide();
            });

            // =========================
            // CHECKBOX CREATE
            // =========================
            $(document).on('change', '.check-pekerjaan', function() {

                handlePekerjaan();
            });

            // =========================
            // CHECKBOX EDIT
            // =========================
            $(document).on('change', '.check-jenis-edit', function() {

                handlePekerjaan('edit_');
            });

        });

        // =====================================
        // HANDLE CHECKBOX PEKERJAAN
        // =====================================
        function handlePekerjaan(prefix = '') {

            let chkBaket =
                (prefix === 'edit_') ?
                $('#edit_baket') :
                $('#checkBaket');

            let chkBreker =
                (prefix === 'edit_') ?
                $('#edit_breker') :
                $('#checkBreker');

            // =========================
            // BAKET
            // =========================
            if (chkBaket.is(':checked')) {

                $('#' + prefix + 'div_harga_baket')
                    .slideDown();

                $('#' + prefix + 'harga_sewa_baket')
                    .prop('required', true);

            } else {

                $('#' + prefix + 'div_harga_baket')
                    .slideUp();

                $('#' + prefix + 'harga_sewa_baket')
                    .prop('required', false)
                    .val(0);
            }

            // =========================
            // BREKER
            // =========================
            if (chkBreker.is(':checked')) {

                $('#' + prefix + 'div_harga_breker')
                    .slideDown();

                $('#' + prefix + 'harga_sewa_breker')
                    .prop('required', true);

            } else {

                $('#' + prefix + 'div_harga_breker')
                    .slideUp();

                $('#' + prefix + 'harga_sewa_breker')
                    .prop('required', false)
                    .val(0);
            }
        }

        // =====================================
        // EDIT TRANSAKSI
        // =====================================
        function editTransaksi(id) {

            $.get("/transaksi/" + id + "/edit", function(data) {

                let row = data.transaksi;

                $('#formEdit')
                    .attr('action', '/transaksi/' + id);

                $('#edit_alat_berat_id')
                    .val(row.alat_berat_id);

                $('#edit_operator_id')
                    .val(row.operator_id);

                $('#edit_pelanggan_id')
                    .val(row.pelanggan_id);

                $('#edit_jenis_sewa')
                    .val(row.jenis_sewa);

                $('#edit_lokasi_proyek')
                    .val(row.lokasi_proyek);

                $('#edit_mobilisasi')
                    .val(row.mobilisasi);

                $('#edit_demobilisasi')
                    .val(row.demobilisasi);

                $('#edit_biaya_modem')
                    .val(row.biaya_modem);

                $('#edit_tanggal_mulai')
                    .val(row.tanggal_mulai);

                $('#edit_tanggal_selesai')
                    .val(row.tanggal_selesai);

                $('#edit_harga_sewa_baket')
                    .val(row.harga_sewa_baket);

                $('#edit_harga_sewa_breker')
                    .val(row.harga_sewa_breker);

                $('#edit_status')
                    .val(row.status);

                // RESET CHECKBOX
                $('.check-jenis-edit')
                    .prop('checked', false);

                // CHECK JENIS PEKERJAAN
                if (
                    row.jenis_pekerjaan &&
                    Array.isArray(row.jenis_pekerjaan)
                ) {

                    row.jenis_pekerjaan.forEach(v => {

                        $(`.check-jenis-edit[value="${v}"]`)
                            .prop('checked', true);
                    });
                }

                // SHOW HIDE FORM
                handlePekerjaan('edit_');

                // SHOW MODAL
                $('#editModal').modal('show');

            }).fail(function() {

                Swal.fire(
                    "Error",
                    "Gagal mengambil data",
                    "error"
                );
            });
        }

        // =====================================
        // DETAIL TRANSAKSI
        // =====================================
        function detailTransaksi(id) {

            $.get("/transaksi/" + id + "/edit", function(data) {

                let row = data.transaksi;

                $('#det_id_transaksi')
                    .text(row.id);

                $('#det_pelanggan')
                    .text(row.pelanggan ?
                        row.pelanggan.nama :
                        '-');

                $('#det_alat')
                    .text(row.alat ?
                        row.alat.nama_alat :
                        '-');

                $('#det_operator')
                    .text(row.operator ?
                        row.operator.nama :
                        '-');

                $('#det_lokasi')
                    .text(row.lokasi_proyek);

                $('#det_mobdem')
                    .text(
                        row.mobilisasi +
                        " / " +
                        row.demobilisasi
                    );

                $('#det_biaya_modem')
                    .text(
                        'Rp ' +
                        new Intl.NumberFormat('id-ID')
                        .format(row.biaya_modem)
                    );

                // JENIS PEKERJAAN
                let pekerjaan =
                    row.jenis_pekerjaan ?
                    row.jenis_pekerjaan.join(', ') :
                    '-';

                $('#det_pekerjaan')
                    .text(pekerjaan.toUpperCase());

                // HARGA
                $('#det_harga_baket')
                    .text(
                        'Rp ' +
                        new Intl.NumberFormat('id-ID')
                        .format(row.harga_sewa_baket)
                    );

                $('#det_harga_breker')
                    .text(
                        'Rp ' +
                        new Intl.NumberFormat('id-ID')
                        .format(row.harga_sewa_breker)
                    );

                // TANGGAL
                let tglMulai =
                    row.tanggal_mulai ?
                    new Date(row.tanggal_mulai)
                    .toLocaleDateString('id-ID') :
                    '-';

                let tglSelesai =
                    row.tanggal_selesai ?
                    new Date(row.tanggal_selesai)
                    .toLocaleDateString('id-ID') :
                    '-';

                $('#det_tanggal')
                    .text(
                        tglMulai +
                        ' s/d ' +
                        tglSelesai
                    );

                // STATUS BADGE
                let badgeClass =
                    row.status == 'berjalan' ?
                    'bg-warning' :
                    (
                        row.status == 'selesai' ?
                        'bg-success' :
                        'bg-danger'
                    );

                $('#det_status').html(
                    `<span class="badge ${badgeClass}">
                        ${row.status.toUpperCase()}
                    </span>`
                );

                // BUTTON CETAK
                $('#btn_invoice')
                    .attr(
                        'href',
                        '/transaksi/invoice/' + row.id
                    );

                $('#btn_surat_jalan')
                    .attr(
                        'href',
                        '/transaksi/surat-jalan/' + row.id
                    );

                // SHOW MODAL
                $('#detailModal')
                    .modal('show');

            }).fail(function() {

                Swal.fire(
                    "Error",
                    "Gagal mengambil detail data",
                    "error"
                );
            });
        }

        // =====================================
        // DELETE
        // =====================================
        function deleteTransaksi(id) {

            globalDelete(
                id,
                "/transaksi/" + id,
                "Transaksi"
            );
        }
    </script>
@endsection
