<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Data Alat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formEdit" class="ajax-form" method="POST" enctype="multipart/form-data"
                    data-modal-id="#editModal">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-bold">Transaksi Alat</label>
                        <input type="text" class="form-control bg-light" id="edit_transaksi_display" readonly>
                        <input type="hidden" id="edit_transaksi_sewa_id" name="transaksi_sewa_id">
                    </div>

                    <div class="mb-3">
                        <label for="edit_tanggal_kerja" class="form-label">Tanggal Kerja</label>
                        <input type="date" class="form-control" id="edit_tanggal_kerja" name="tanggal" required />
                    </div>

                    <div class="mb-3">
                        <label for="edit_hm_awal" class="form-label">HM Awal</label>
                        <input type="number" class="form-control" id="edit_hm_awal" name="hm_awal" required />
                    </div>

                    <div class="mb-3">
                        <label for="edit_hm_akhit" class="form-label">HM Awal</label>
                        <input type="number" class="form-control" id="edit_hm_akhir" name="hm_akhir" required />
                    </div>

                    <div class="mb-3">
                        <label for="edit_jam_baket" class="form-label">Jam Baket</label>
                        <input type="number" class="form-control" id="edit_jam_baket" name="jam_baket" required />
                    </div>
                    <div class="mb-3">
                        <label for="edit_jam_breker" class="form-label">Jam Breker</label>
                        <input type="number" class="form-control" id="edit_jam_breker" name="jam_breker" required />
                    </div>
                    <div class="mb-3">
                        <label for="edit_tanggal_awal_hm" class="form-label">Tanggal Awal HM</label>
                        <input type="date" class="form-control" id="edit_tanggal_awal_hm" name="tanggal_awal_hm"
                            required />
                    </div>
                    <div class="mb-3">
                        <label for="edit_tanggal_akhir_hm" class="form-label">Tanggal Akhir HM</label>
                        <input type="date" class="form-control" id="edit_tanggal_akhir_hm" name="tanggal_akhir_hm"
                            required />
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-xs" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-xs">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
