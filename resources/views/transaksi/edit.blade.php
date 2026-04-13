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
                        <label for="edit_pelanggan_id" class="form-label">Penyewa</label>
                        <select class="form-select" id="edit_pelanggan_id" name="pelanggan_id" required>
                            <option value="">-- Pilih Pelanggan --</option>
                            @foreach ($pelanggan as $row)
                                <option value="{{ $row->id }}">{{ $row->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_operator_id" class="form-label">Operator</label>
                        <select class="form-select" id="edit_operator_id" name="operator_id" required>
                            <option value="">-- Pilih Operator --</option>
                            @foreach ($operator as $row)
                                <option value="{{ $row->id }}">{{ $row->nama }}</option>
                            @endforeach
                        </select>
                    </div>
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
                        <label for="edit_jenis_sewa" class="form-label">Jenis Sewa</label>
                        <input type="text" class="form-control" id="edit_jenis_sewa" name="jenis_sewa" required />
                    </div>

                    <div class="mb-3">
                        <label class="form-label d-block">Jenis Pekerjaan</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input check-jenis-edit" type="checkbox" name="jenis_pekerjaan[]"
                                value="baket" id="edit_baket">
                            <label class="form-check-label" for="edit_baket">Baket</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input check-jenis-edit" type="checkbox" name="jenis_pekerjaan[]"
                                value="breker" id="edit_breker">
                            <label class="form-check-label" for="edit_breker">Breker</label>
                        </div>
                    </div>

                    <div class="mb-3" id="edit_div_harga_baket" style="display: none;">
                        <label for="edit_harga_sewa_baket" class="form-label font-weight-bold">Harga Baket</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">Rp</span>
                            <input type="number" class="form-control" id="edit_harga_sewa_baket"
                                name="harga_sewa_baket" placeholder="0">
                        </div>
                    </div>

                    <div class="mb-3" id="edit_div_harga_breker" style="display: none;">
                        <label for="edit_harga_sewa_breker" class="form-label font-weight-bold">Harga
                            Breker</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">Rp</span>
                            <input type="number" class="form-control" id="edit_harga_sewa_breker"
                                name="harga_sewa_breker" placeholder="0">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="edit_lokasi_proyek" class="form-label">Lokasi Proyek</label>
                        <input type="text" class="form-control" id="edit_lokasi_proyek" name="lokasi_proyek"
                            required />
                    </div>
                    <div class="mb-3">
                        <label for="edit_mobilisasi" class="form-label">Mobilisasi</label>
                        <input type="text" class="form-control" id="edit_mobilisasi" name="mobilisasi"
                            required />
                    </div>
                    <div class="mb-3">
                        <label for="edit_demobilisasi" class="form-label">Demobilisasi</label>
                        <input type="text" class="form-control" id="edit_demobilisasi" name="demobilisasi"
                            required />
                    </div>
                    <div class="mb-3">
                        <label for="edit_biaya_modem" class="form-label">Biaya Modem</label>
                        <input type="number" class="form-control" id="edit_biaya_modem" name="biaya_modem"
                            required />
                    </div>

                    <div class="mb-3">
                        <label for="edit_tanggal_mulai" class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="edit_tanggal_mulai" name="tanggal_mulai"
                            required />
                    </div>

                    <div class="mb-3">
                        <label for="edit_tanggal_selesai" class="form-label">Tanggal Selesai</label>
                        <input type="date" class="form-control" id="edit_tanggal_selesai"
                            name="tanggal_selesai" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status" id="edit_status">
                            <option value="berjalan">Berjalan</option>
                            <option value="selesai">Selesai</option>
                            <option value="batal">Batal</option>
                        </select>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-xs"
                            data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary btn-xs">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
