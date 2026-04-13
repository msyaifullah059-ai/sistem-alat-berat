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
                <form id="formTambah" class="forms-sample ajax-form" action="{{ route('alat.store') }}" method="POST"
                    enctype="multipart/form-data" data-modal-id="#createModal">
                    @csrf

                    <div class="mb-3">
                        <label for="kode_unit" class="form-label">Kode</label>
                        <input type="text" class="form-control" id="kode_unit" name="kode_unit" placeholder="Kode"
                            required />
                    </div>
                    <div class="mb-3">
                        <label for="nama_alat" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama_alat" name="nama_alat" placeholder="Nama"
                            required />
                    </div>
                    <div class="mb-3">
                        <label for="jenis" class="form-label">Jenis</label>
                        <input type="text" class="form-control" id="jenis" name="jenis" placeholder="Jenis"
                            required />
                    </div>
                    <div class="mb-3">
                        <label for="merk" class="form-label">Merk</label>
                        <input type="text" class="form-control" id="merk" name="merk" placeholder="Merk"
                            required />
                    </div>
                    <div class="mb-3">
                        <label for="tahun" class="form-label">Tahun</label>
                        <input type="number" class="form-control" id="tahun" name="tahun" placeholder="Tahun"
                            required />
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" aria-label="Default select example" id="status" name="status">
                            <option value="">Pilih Status</option>
                            <option value="good">Good</option>
                            <option value="maintenance">Maintenance</option>
                            <option value="broken">Broken</option>
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
