@extends('admin')

@section('title', 'Pricing')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="dashboard">Dashboard</a>
            </li>

            <li class="breadcrumb-item active">
                Pricing
            </li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">

                <div class="card-body">

                    <div class="d-flex flex-row align-items-center justify-content-between border-bottom small mb-3">

                        <h6 class="card-title">
                            Data Harga Sewa
                        </h6>

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
                                    <th>Harga Baket</th>
                                    <th>Harga Breker</th>
                                    <th>Masa Berlaku</th>
                                    <th width="120">Aksi</th>
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
        let table;

        $(document).ready(function() {

            table = $('#dataPricing').DataTable({

                processing: true,
                serverSide: true,

                ajax: "{{ route('pricing.index') }}",

                columns: [

                    {
                        data: 'alat.nama_alat',
                        name: 'alat.nama_alat'
                    },

                    {
                        data: 'jenis_pekerjaan',
                        name: 'jenis_pekerjaan',

                        render: function(data) {

                            if (!data || data.length === 0) {
                                return '-';
                            }

                            return data.map(function(item) {

                                return item.charAt(0).toUpperCase() + item.slice(1);

                            }).join(' - ');
                        }
                    },
                    {
                        data: 'harga_sewa_jam_baket',
                        name: 'harga_sewa_jam_baket',
                        render: function(data) {
                            if (!data) return '-';

                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(data);
                        }
                    },
                    {
                        data: 'harga_sewa_jam_breker',
                        name: 'harga_sewa_jam_breker',
                        render: function(data) {
                            if (!data) return '-';

                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(data);
                        }
                    },

                    {
                        data: null,
                        name: 'periode',
                        render: function(data, type, row) {

                            if (!row.berlaku_mulai) return '-';

                            let mulai = new Date(row.berlaku_mulai)
                                .toLocaleDateString('id-ID');

                            let selesai = row.berlaku_selesai ?
                                new Date(row.berlaku_selesai)
                                .toLocaleDateString('id-ID') :
                                '-';

                            return mulai + ' - ' + selesai;

                            // atau:
                            // return mulai + ' s/d ' + selesai;
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

        // =====================================================
        // EDIT
        // =====================================================

        function editPricing(id) {

            $.get("/pricing/" + id + "/edit", function(data) {

                let pricing = data.pricing;

                $('#formEdit').attr('action', '/pricing/' + id);

                $('#edit_alat_berat_id').val(pricing.alat_berat_id);

                // RESET
                $('#edit_baket').prop('checked', false);
                $('#edit_breker').prop('checked', false);

                $('#edit_baket_form').addClass('d-none');
                $('#edit_breker_form').addClass('d-none');

                let jenis = pricing.jenis_pekerjaan ?? [];

                // BAKET
                if (jenis.includes('baket')) {

                    $('#edit_baket').prop('checked', true);

                    $('#edit_baket_form').removeClass('d-none');

                    // $('#edit_harga_sewa_hari_baket')
                    //     .val(pricing.harga_sewa_hari_baket);

                    $('#edit_harga_sewa_jam_baket')
                        .val(pricing.harga_sewa_jam_baket);
                }

                // BREKER
                if (jenis.includes('breker')) {

                    $('#edit_breker').prop('checked', true);

                    $('#edit_breker_form').removeClass('d-none');

                    // $('#edit_harga_sewa_hari_breker')
                    //     .val(pricing.harga_sewa_hari_breker);

                    $('#edit_harga_sewa_jam_breker')
                        .val(pricing.harga_sewa_jam_breker);
                }

                $('#edit_berlaku_mulai')
                    .val(pricing.berlaku_mulai);

                $('#edit_berlaku_selesai')
                    .val(pricing.berlaku_selesai);

                $('#editModal').modal('show');
            });
        }

        $('#edit_baket').change(function() {

            $('#edit_baket_form')
                .toggleClass('d-none', !this.checked);
        });

        $('#edit_breker').change(function() {

            $('#edit_breker_form')
                .toggleClass('d-none', !this.checked);
        });

        // =====================================================
        // DELETE
        // =====================================================

        function deletePricing(id) {
            globalDelete(
                id,
                "/pricing/" + id,
                "Pricing"
            );
        }
    </script>

@endsection
