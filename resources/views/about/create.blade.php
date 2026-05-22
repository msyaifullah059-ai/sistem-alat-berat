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
                <form id="formTambah" class="forms-sample ajax-form" action="{{ route('about.store') }}" method="POST"
                    enctype="multipart/form-data" data-modal-id="#createModal">
                    @csrf

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"
                            oninput="this.style.height='';this.style.height=this.scrollHeight+'px'" placeholder="Deskripsi" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="gambar">Gambar</label>

                        <input class="form-control" type="file" id="gambar" name="gambar" accept="image/*" />

                        <div class="mt-2">
                            <img id="previewGambar" src="" alt="Preview"
                                style="max-width:120px; display:none; border-radius:6px;">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-xs" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary btn-xs">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
