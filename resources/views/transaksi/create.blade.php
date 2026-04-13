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
                <form id="formTambah" class="forms-sample ajax-form" action="{{ route('transaksi.store') }}"
                    method="POST" enctype="multipart/form-data" data-modal-id="#createModal">
                    @csrf

                    <div class="mb-3">
                        <label for="pelanggan_id" class="form-label">Penyewa</label>
                        <select class="form-select" aria-label="Default select example" id="pelanggan_id"
                            name="pelanggan_id">
                            <option value="">-- Pilih Penyewa --</option>
                            @foreach ($pelanggan as $row)
                                <option value="{{ $row->id }}">{{ $row->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="operator_id" class="form-label">Operator</label>
                        <select class="form-select" aria-label="Default select example" id="operator_id"
                            name="operator_id">
                            <option value="">-- Pilih Operator --</option>
                            @foreach ($operator as $row)
                                <option value="{{ $row->id }}">{{ $row->nama }}</option>
                            @endforeach
                        </select>
                    </div>
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
                        <label class="form-label d-block">Jenis Pekerjaan</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input check-pekerjaan" type="checkbox" name="jenis_pekerjaan[]"
                                value="baket" id="checkBaket">
                            <label class="form-check-label" for="checkBaket">Baket</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input check-pekerjaan" type="checkbox" name="jenis_pekerjaan[]"
                                value="breker" id="checkBreker">
                            <label class="form-check-label" for="checkBreker">Breker</label>
                        </div>
                    </div>

                    <div class="mb-3" id="div_harga_baket" style="display: none;">
                        <label for="harga_sewa_baket" class="form-label">Harga Baket</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted">Rp</span>
                            <input type="number" class="form-control" id="harga_sewa_baket" name="harga_sewa_baket"
                                placeholder="0" />
                        </div>
                    </div>

                    <div class="mb-3" id="div_harga_breker" style="display: none;">
                        <label for="harga_sewa_breker" class="form-label">Harga Breker</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted">Rp</span>
                            <input type="number" class="form-control" id="harga_sewa_breker" name="harga_sewa_breker"
                                placeholder="0" />
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="jenis_sewa" class="form-label">Jenis Sewa</label>
                        <input type="text" class="form-control" id="jenis_sewa" name="jenis_sewa"
                            placeholder="Jenis Sewa" required />
                    </div>
                    <div class="mb-3">
                        <label for="lokasi_proyek" class="form-label">Lokasi Proyek</label>
                        <input type="text" class="form-control" id="lokasi_proyek" name="lokasi_proyek"
                            placeholder="Lokasi Proyek" required />
                    </div>
                    <div class="mb-3">
                        <label for="mobilisasi" class="form-label">Mobilisasi</label>
                        <input type="text" class="form-control" id="mobilisasi" name="mobilisasi"
                            placeholder="Mobilisasi" required />
                    </div>
                    <div class="mb-3">
                        <label for="demobilisasi" class="form-label">Demobilisasi</label>
                        <input type="text" class="form-control" id="demobilisasi" name="demobilisasi"
                            placeholder="Demobilisasi" required />
                    </div>
                    <div class="mb-3">
                        <label for="biaya_modem" class="form-label">Biaya Modem</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted">Rp</span>
                            <input type="number" class="form-control" id="biaya_modem" name="biaya_modem"
                                placeholder="0" required />
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai"
                            placeholder="Tanggal mulai" required />
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                        <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai"
                            placeholder="Tanggal Selesai" required />
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" aria-label="Default select example" id="status"
                            name="status">
                            <option value="">Pilih Status</option>
                            <option value="berjalan">Berjalan</option>
                            <option value="selesai">Selesai</option>
                            <option value="batal">Batal</option>
                        </select>
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
