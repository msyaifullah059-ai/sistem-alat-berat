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
                        <label for="edit_alat_berat_id" class="form-label">Alat Berat</label>
                        <select class="form-select" id="edit_alat_berat_id" name="alat_berat_id" required>
                            <option value="">-- Pilih Alat Berat --</option>
                            @foreach ($alat as $row)
                                <option value="{{ $row->id }}">{{ $row->nama_alat }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="edit_jenis_pekerjaan" class="form-label">Jenis Pekerjaan</label>
                        <select class="form-select" id="edit_jenis_pekerjaan" name="jenis_pekerjaan" required>
                            <option value="">-- Pilih Jenis --</option>
                            <option value="baket">Baket</option>
                            <option value="breker">Breker</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="edit_harga_per_hari" class="form-label">Harga Sewa/Hari</label>
                        <input type="number" class="form-control" id="edit_harga_per_hari" name="harga_per_hari"
                            required />
                    </div>

                    <div class="mb-3">
                        <label for="edit_harga_per_jam" class="form-label">Harga Sewa/Jam</label>
                        <input type="number" class="form-control" id="edit_harga_per_jam" name="harga_per_jam"
                            required />
                    </div>

                    <div class="mb-3">
                        <label for="edit_berlaku_mulai" class="form-label">Berlaku Mulai</label>
                        <input type="date" class="form-control" id="edit_berlaku_mulai" name="berlaku_mulai"
                            required />
                    </div>

                    <div class="mb-3">
                        <label for="edit_berlaku_selesai" class="form-label">Berlaku Selesai</label>
                        <input type="date" class="form-control" id="edit_berlaku_selesai" name="berlaku_selesai" />
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
