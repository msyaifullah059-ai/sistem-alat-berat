<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Data Tentang Kita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formEditAbout" class="ajax-form" method="POST" enctype="multipart/form-data"
                    data-modal-id="#editModal">
                    @csrf
                    @method('PUT') {{-- WAJIB: Laravel butuh ini untuk update --}}

                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea class="form-control" name="deskripsi" id="edit_deskripsi" rows="3"
                            oninput="this.style.height='';this.style.height=this.scrollHeight+'px'" required></textarea>
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
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
