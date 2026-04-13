<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Data Alat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formEditAlat" class="ajax-form" method="POST" enctype="multipart/form-data"
                    data-modal-id="#editModal">
                    @csrf
                    @method('PUT') {{-- WAJIB: Laravel butuh ini untuk update --}}

                    <div class="mb-3">
                        <label class="form-label">Kode</label>
                        <input type="text" class="form-control" name="kode_unit" id="edit_kode_unit" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" class="form-control" name="nama_alat" id="edit_nama_alat" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis</label>
                        <input type="text" class="form-control" name="jenis" id="edit_jenis" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Merk</label>
                        <input type="text" class="form-control" name="merk" id="edit_merk" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tahun</label>
                        <input type="text" class="form-control" name="tahun" id="edit_tahun" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status" id="edit_status">
                            <option value="good">Good</option>
                            <option value="maintenance">Maintenance</option>
                            <option value="broken">Broken</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Ganti Gambar (Opsional)</label>
                        <input type="file" class="form-control" name="gambar" id="edit_gambar">
                        <div class="mt-2">
                            <p class="small text-muted">Gambar saat ini:</p>
                            <img id="edit_previewGambar" src="" style="max-width:100px; border-radius:6px;">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
