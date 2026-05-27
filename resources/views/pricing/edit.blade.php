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
                        <label class="form-label">Jenis Pekerjaan</label>

                        <div class="form-check">
                            <input class="form-check-input jenis-edit-checkbox" type="checkbox" value="baket"
                                id="edit_baket" name="jenis_pekerjaan[]">

                            <label class="form-check-label" for="edit_baket">
                                Baket
                            </label>
                        </div>

                        <div id="edit_baket_form" class="mt-2 d-none">
                            <div class="row">

                                {{-- <div class="col-md-6">
                                    <label class="form-label">
                                        Harga Baket/Hari
                                    </label>

                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>

                                        <input type="number" class="form-control" id="edit_harga_sewa_hari_baket"
                                            name="harga_sewa_hari_baket">
                                    </div>
                                </div> --}}

                                <div class="col-md-6">
                                    <label class="form-label">
                                        Harga Baket/Jam
                                    </label>

                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>

                                        <input type="number" class="form-control" id="edit_harga_sewa_jam_baket"
                                            name="harga_sewa_jam_baket">
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="form-check mt-3">
                            <input class="form-check-input jenis-edit-checkbox" type="checkbox" value="breker"
                                id="edit_breker" name="jenis_pekerjaan[]">

                            <label class="form-check-label" for="edit_breker">
                                Breker
                            </label>
                        </div>

                        <div id="edit_breker_form" class="mt-2 d-none">
                            <div class="row">

                                {{-- <div class="col-md-6">
                                    <label class="form-label">
                                        Harga Breker/Hari
                                    </label>

                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>

                                        <input type="number" class="form-control" id="edit_harga_sewa_hari_breker"
                                            name="harga_sewa_hari_breker">
                                    </div>
                                </div> --}}

                                <div class="col-md-6">
                                    <label class="form-label">
                                        Harga Breker/Jam
                                    </label>

                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>

                                        <input type="number" class="form-control" id="edit_harga_sewa_jam_breker"
                                            name="harga_sewa_jam_breker">
                                    </div>
                                </div>

                            </div>
                        </div>
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
                        <button type="submit" class="btn btn-primary btn-xs">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
