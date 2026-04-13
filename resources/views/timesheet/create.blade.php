<!-- Modal -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">
                    Tambah Data
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <form id="formTambah" class="forms-sample ajax-form" action="{{ route('timesheet.store') }}"
                    method="POST" data-modal-id="#createModal">
                    @csrf

                    <div class="mb-3">
                        <label for="transaksi_sewa_id" class="form-label">Transaksi Alat Berjalan</label>
                        <select class="form-select" id="transaksi_sewa_id" name="transaksi_sewa_id" required>
                            <option value="">-- Pilih Transaksi --</option>
                            @foreach ($transaksi as $row)
                                @php
                                    $pekerjaan = is_array($row->jenis_pekerjaan)
                                        ? implode(',', $row->jenis_pekerjaan)
                                        : $row->jenis_pekerjaan;
                                @endphp
                                <option value="{{ $row->id }}" data-pekerjaan="{{ strtolower($pekerjaan) }}">
                                    {{ $row->pelanggan->nama }} | {{ $row->alat->nama_alat }}
                                    ({{ $row->lokasi_proyek }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div id="detail-timesheet" style="display: none;">

                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal Kerja</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" required />
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="hm_awal" class="form-label">HM Awal</label>
                                    <input type="number" class="form-control" id="hm_awal" name="hm_awal"
                                        placeholder="0" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="hm_akhir" class="form-label">HM Akhir</label>
                                    <input type="number" class="form-control" id="hm_akhir" name="hm_akhir"
                                        placeholder="0" required />
                                </div>
                            </div>
                        </div>

                        <hr>
                        <p class="text-muted small mb-3 text-italic">*Isi jam kerja sesuai jenis pekerjaan yang
                            dilakukan
                        </p>

                        <div class="row">
                            <div class="col-md-6" id="container_baket" style="display: none;">
                                <div class="mb-3">
                                    <label for="jam_baket" class="form-label">Jam Baket</label>
                                    <div class="input-group">
                                        <input type="number" step="0.1" class="form-control" id="jam_baket"
                                            name="jam_baket" placeholder="0" />
                                        <span class="input-group-text">Jam</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6" id="container_breker" style="display: none;">
                                <div class="mb-3">
                                    <label for="jam_breker" class="form-label">Jam Breker</label>
                                    <div class="input-group">
                                        <input type="number" step="0.1" class="form-control" id="jam_breker"
                                            name="jam_breker" placeholder="0" />
                                        <span class="input-group-text">Jam</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_awal_hm" class="form-label">Tanggal Awal HM</label>
                            <input type="date" class="form-control" id="tanggal_awal_hm" name="tanggal_awal_hm"
                                required />
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_akhir_hm" class="form-label">Tanggal Akhir HM</label>
                            <input type="date" class="form-control" id="tanggal_akhir_hm" name="tanggal_akhir_hm"
                                required />
                        </div>
                    </div>

                    <div class="modal-footer px-0 pb-0">
                        <button type="button" class="btn btn-secondary btn-xs"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-xs">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // 1. Logic Toggle Kolom & Form Detail
        $('#transaksi_sewa_id').on('change', function() {
            let selectedOption = $(this).find(':selected');
            let pekerjaan = selectedOption.data('pekerjaan') || '';

            // Sembunyikan dulu semua
            $('#detail-timesheet').hide();
            $('#container_baket, #container_breker').hide();

            // Reset nilai agar tidak nyampur
            $('#jam_baket, #jam_breker').val('').removeAttr('required');

            if ($(this).val() !== "") {
                $('#detail-timesheet').fadeIn();

                // Cek Jenis Pekerjaan (Case Insensitive)
                if (pekerjaan.indexOf('baket') !== -1) {
                    $('#container_baket').show();
                    $('#jam_baket').attr('required', true);
                }
                if (pekerjaan.indexOf('breker') !== -1) {
                    $('#container_breker').show();
                    $('#jam_breker').attr('required', true);
                }
            }
        });

        // 2. Validasi HM Akhir vs HM Awal
        $('#hm_akhir').on('change', function() {
            let awal = parseFloat($('#hm_awal').val()) || 0;
            let akhir = parseFloat($(this).val()) || 0;

            if (akhir < awal && akhir !== 0) {
                alert("⚠️ Waduh bro, HM Akhir gak boleh lebih kecil dari HM Awal!");
                $(this).val('').focus();
            }
        });

        // 3. Reset Form Otomatis pas Modal ditutup
        $('#createModal').on('hidden.bs.modal', function() {
            $('#formTambah')[0].reset();
            $('#detail-timesheet').hide();
        });
    });
</script>
