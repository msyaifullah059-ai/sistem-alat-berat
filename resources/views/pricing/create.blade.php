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
                <form id="formTambah" class="forms-sample ajax-form" action="{{ route('pricing.store') }}"
                    method="POST" enctype="multipart/form-data" data-modal-id="#createModal">
                    @csrf

                    <div class="mb-3">
                        <label for="alat_berat_id" class="form-label">Alat Berat</label>
                        <select class="form-select" aria-label="Default select example" id="alat_berat_id"
                            name="alat_berat_id">
                            <option value="">-- Pilih Alat Berat --</option>
                            @foreach ($alat as $row)
                                <option value="{{ $row->id }}">{{ $row->nama_alat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="jenis_pekerjaan" class="form-label">Alat Berat</label>
                        <select class="form-select" aria-label="Default select example" id="jenis_pekerjaan"
                            name="jenis_pekerjaan">
                            <option value="">-- Jenis Pekerjaan --</option>
                            <option value="baket">Baket</option>
                            <option value="breker">Breker</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="harga_per_hari" class="form-label">Harga sewa/Hari</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted">Rp</span>
                            <input type="number" class="form-control" id="harga_per_hari" name="harga_per_hari"
                                placeholder="0" required />
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="harga_per_jam" class="form-label">Harga sewa/Jam</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted">Rp</span>
                            <input type="number" class="form-control" id="harga_per_jam" name="harga_per_jam"
                                placeholder="0" required />
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="berlaku_mulai" class="form-label">Berlaku mulai</label>
                        <input type="date" class="form-control" id="berlaku_mulai" name="berlaku_mulai"
                            placeholder="Berlaku mulai" required />
                    </div>
                    <div class="mb-3">
                        <label for="berlaku_selesai" class="form-label">Berlaku Selesai</label>
                        <input type="date" class="form-control" id="berlaku_selesai" name="berlaku_selesai"
                            placeholder="Berlaku Selesai" required />
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
