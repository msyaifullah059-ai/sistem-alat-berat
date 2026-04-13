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
                <form id="formTambah" class="forms-sample ajax-form" action="{{ route('operator.store') }}" method="POST"
                    enctype="multipart/form-data" data-modal-id="#createModal">
                    @csrf

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama"
                            required />
                    </div>
                    <div class="mb-3">
                        <label for="no_hp" class="form-label">Kontak</label>
                        <input type="number" class="form-control" id="no_hp" name="no_hp" placeholder="Kontak"
                            required />
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Alamat"
                            required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="ktp">KTP</label>

                        <input class="form-control" type="file" id="ktp" name="ktp" accept="image/*" />

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
