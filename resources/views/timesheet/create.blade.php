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
                                {{-- Kita tampilin Nama Pelanggan & Nama Alat biar user gak bingung --}}
                                <option value="{{ $row->id }}">
                                    {{ $row->pelanggan->nama }} | {{ $row->alat->nama_alat }}
                                    ({{ $row->lokasi_proyek }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" aria-label="Default select example" id="status" name="status">
                            <option value="">Pilih Status</option>
                            <option value="Berjalan">Berjalan</option>
                            <option value="Selesai">Selesai</option>
                        </select>
                    </div>

                    <div class="modal-footer px-0 pb-0">
                        <button type="button" class="btn btn-secondary btn-xs" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-xs">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
</script> --}}
