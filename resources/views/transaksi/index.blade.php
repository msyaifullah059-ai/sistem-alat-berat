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
                    <div class="shadow-sm border-left-primary mb-3">
                        <label for="filter_status" class="form-label fw-bold text-primary">Status Transaksi</label>
                        <select class="form-select border-primary" id="filter_status">
                            <option value="">-- Pilih Status Dahulu --</option>
                            <option value="berjalan">Berjalan</option>
                            <option value="selesai">Selesai</option>
                            <option value="batal">Batal</option>
                        </select>
                    </div>
                    <hr>
                    <div id="containerTable" style="display: none;">
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
                                        <th>Operator</th>
                                        <th>Alat</th>
                                        <th>Jenis Sewa</th>
                                        <th>Lokasi Proyek</th>
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
            table = $('#dataTransaksi').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('transaksi.index') }}",
                    data: function(d) {
                        // Kirim status ke server
                        d.status = $('#filter_status').val();
                    }
                },
                columns: [{
                        data: 'pelanggan.nama',
                        name: 'pelanggan.nama'
                    },
                    {
                        data: 'operator.nama',
                        name: 'operator.nama'
                    },
                    {
                        data: 'alat.nama_alat',
                        name: 'alat.nama_alat'
                    },
                    {
                        data: 'jenis_sewa',
                        name: 'jenis_sewa'
                    },
                    {
                        data: 'lokasi_proyek',
                        name: 'lokasi_proyek'
                    },
                    // {
                    //     data: 'tanggal_mulai',
                    //     render: data => data ? new Date(data).toLocaleDateString('id-ID') : '-'
                    // },
                    // {
                    //     data: 'tanggal_selesai',
                    //     render: data => data ? new Date(data).toLocaleDateString('id-ID') : '-'
                    // },
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

            // Trigger Reload saat Filter Status Berubah
            $('#filter_status').on('change', function() {
                let val = $(this).val();
                if (val) {
                    $('#containerTable').fadeIn('slow');
                    table.ajax.reload();

                    // OPSI: Set status di Modal Create otomatis sesuai filter
                    $('#status').val(val);
                } else {
                    $('#containerTable').fadeOut('fast');
                }
            });

            // Reset Modal pas ditutup
            $('#createModal').on('hidden.bs.modal', function() {
                $(this).find('form')[0].reset();
                $('#div_harga_baket, #div_harga_breker').hide();

                // Balikin status ke filter yang aktif
                let currentStatus = $('#filter_status').val();
                if (currentStatus) $('#status').val(currentStatus);
            });

            // Logic Checkbox (Create & Edit)
            $(document).on('change', '.check-pekerjaan', function() {
                handlePekerjaan();
            });
            $(document).on('change', '.check-jenis-edit', function() {
                handlePekerjaan('edit_');
            });
        });

        // --- Fungsi Helper (handlePekerjaan, editTransaksi, deleteTransaksi tetap sama) ---
        function handlePekerjaan(prefix = '') {
            let chkBaket = (prefix === 'edit_') ? $('#edit_baket') : $('#checkBaket');
            let chkBreker = (prefix === 'edit_') ? $('#edit_breker') : $('#checkBreker');

            if (chkBaket.is(':checked')) {
                $('#' + prefix + 'div_harga_baket').slideDown();
                $('#' + prefix + 'harga_sewa_baket').prop('required', true);
            } else {
                $('#' + prefix + 'div_harga_baket').slideUp();
                $('#' + prefix + 'harga_sewa_baket').prop('required', false).val(0);
            }

            if (chkBreker.is(':checked')) {
                $('#' + prefix + 'div_harga_breker').slideDown();
                $('#' + prefix + 'harga_sewa_breker').prop('required', true);
            } else {
                $('#' + prefix + 'div_harga_breker').slideUp();
                $('#' + prefix + 'harga_sewa_breker').prop('required', false).val(0);
            }
        }

        function editTransaksi(id) {
            $.get("/transaksi/" + id + "/edit", function(data) {
                let row = data.transaksi;
                $('#formEdit').attr('action', '/transaksi/' + id);

                $('#edit_alat_berat_id').val(row.alat_berat_id);
                $('#edit_operator_id').val(row.operator_id);
                $('#edit_pelanggan_id').val(row.pelanggan_id);
                $('#edit_jenis_sewa').val(row.jenis_sewa);
                $('#edit_lokasi_proyek').val(row.lokasi_proyek);
                $('#edit_mobilisasi').val(row.mobilisasi);
                $('#edit_demobilisasi').val(row.demobilisasi);
                $('#edit_biaya_modem').val(row.biaya_modem);
                $('#edit_tanggal_mulai').val(row.tanggal_mulai);
                $('#edit_tanggal_selesai').val(row.tanggal_selesai);
                $('#edit_harga_sewa_baket').val(row.harga_sewa_baket);
                $('#edit_harga_sewa_breker').val(row.harga_sewa_breker);
                $('#edit_status').val(row.status);

                $('.check-jenis-edit').prop('checked', false);
                if (row.jenis_pekerjaan && Array.isArray(row.jenis_pekerjaan)) {
                    row.jenis_pekerjaan.forEach(v => $(`.check-jenis-edit[value="${v}"]`).prop('checked', true));
                }

                if ($('#edit_baket').is(':checked')) $('#edit_div_harga_baket').show();
                else $('#edit_div_harga_baket').hide();
                if ($('#edit_breker').is(':checked')) $('#edit_div_harga_breker').show();
                else $('#edit_div_harga_breker').hide();

                $('#editModal').modal('show');
            }).fail(() => Swal.fire("Error", "Gagal mengambil data", "error"));
        }

        function detailTransaksi(id) {
            $.get("/transaksi/" + id + "/edit", function(data) {
                let row = data.transaksi;

                // Isi data ke Modal Detail
                $('#det_id_transaksi').text(row.id);
                $('#det_pelanggan').text(row.pelanggan ? row.pelanggan.nama : '-');
                $('#det_alat').text(row.alat ? row.alat.nama_alat : '-');
                $('#det_operator').text(row.operator ? row.operator.nama : '-');
                $('#det_lokasi').text(row.lokasi_proyek);
                $('#det_mobdem').text(row.mobilisasi + " / " + row.demobilisasi);
                $('#det_biaya_modem').text('Rp ' + new Intl.NumberFormat('id-ID').format(row.biaya_modem));

                // Gabungin array jenis pekerjaan jadi teks
                let pekerjaan = row.jenis_pekerjaan ? row.jenis_pekerjaan.join(', ') : '-';
                $('#det_pekerjaan').text(pekerjaan.toUpperCase());

                // Format Rupiah
                $('#det_harga_baket').text('Rp ' + new Intl.NumberFormat('id-ID').format(row.harga_sewa_baket));
                $('#det_harga_breker').text('Rp ' + new Intl.NumberFormat('id-ID').format(row.harga_sewa_breker));

                // Format Tanggal
                let tglMulai = row.tanggal_mulai ? new Date(row.tanggal_mulai).toLocaleDateString('id-ID') : '-';
                let tglSelesai = row.tanggal_selesai ? new Date(row.tanggal_selesai).toLocaleDateString('id-ID') :
                    '-';
                $('#det_tanggal').text(tglMulai + ' s/d ' + tglSelesai);

                // Status dengan Badge
                let badgeClass = row.status == 'berjalan' ? 'bg-warning' : (row.status == 'selesai' ? 'bg-success' :
                    'bg-danger');
                $('#det_status').html(`<span class="badge ${badgeClass}">${row.status.toUpperCase()}</span>`);

                // --- UPDATE LINK TOMBOL CETAK ---
                // Kita arahkan href tombol ke route print dengan ID yang sesuai
                $('#btn_invoice').attr('href', '/transaksi/invoice/' + row.id);
                $('#btn_surat_jalan').attr('href', '/transaksi/surat-jalan/' + row.id);

                // Munculkan Modal
                $('#detailModal').modal('show');
            }).fail(function() {
                Swal.fire("Error", "Gagal mengambil detail data", "error");
            });
        }

        function deleteTransaksi(id) {
            globalDelete(id, "/transaksi/" + id, "Transaksi");
        }
    </script>
@endsection
