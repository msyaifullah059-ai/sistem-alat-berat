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
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nama user"
                            required />
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Nama</label>
                        <input type="email" class="form-control" id="email" name="email"
                            placeholder="user@gmail.com" required />
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select" aria-label="Default select example" id="role"
                            name="role">
                            <option value="">-- Pilih Role --</option>
                            <option value="admin">Admin</option>
                            <option value="staff">Staff</option>
                        </select>
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
