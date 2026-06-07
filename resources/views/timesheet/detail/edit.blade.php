<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form id="formEdit" method="POST" enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="modal-header">

                    <h5 class="modal-title">

                        Edit Detail Timesheet

                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <div class="row">

                        {{-- TANGGAL PEKERJAAN --}}
                        <div class="col-md-6 mb-3">

                            <label class="form-label">

                                Tanggal Pekerjaan

                            </label>

                            <input type="date" id="edit_tanggal_pekerjaan" name="tanggal_pekerjaan"
                                class="form-control" required>

                        </div>

                        {{-- TANGGAL PEKERJAAN --}}
                        <div class="col-md-6 mb-3">

                            <label class="form-label">

                                Tanggal Awal HM

                            </label>

                            <input type="date" id="edit_tanggal_awal_hm" name="tanggal_awal_hm"
                                class="form-control" required>

                        </div>

                        {{-- TANGGAL PEKERJAAN --}}
                        <div class="col-md-6 mb-3">

                            <label class="form-label">

                                Tanggal Akhir HM

                            </label>

                            <input type="date" id="edit_tanggal_akhir_hm," name="tanggal_akhir_hm"
                                class="form-control" required>

                        </div>

                        {{-- JAM BAKET --}}
                        <div class="col-md-6 mb-3">

                            <label class="form-label">

                                Jam Baket

                            </label>

                            <input type="number" id="edit_jam_baket" name="jam_baket" class="form-control"
                                min="0">

                        </div>

                        {{-- HM AWAL --}}
                        <div class="col-md-6 mb-3">

                            <label class="form-label">

                                HM Awal

                            </label>

                            <input type="number" id="edit_hm_awal" name="hm_awal" class="form-control" min="0"
                                required>

                        </div>

                        {{-- HM AKHIR --}}
                        <div class="col-md-6 mb-3">

                            <label class="form-label">

                                HM Akhir

                            </label>

                            <input type="number" id="edit_hm_akhir" name="hm_akhir" class="form-control" min="0"
                                required>

                        </div>

                        {{-- JAM BREKER --}}
                        <div class="col-md-6 mb-3">

                            <label class="form-label">

                                Jam Breker

                            </label>

                            <input type="number" id="edit_jam_breker" name="jam_breker" class="form-control"
                                min="0">

                        </div>

                        {{-- GAMBAR --}}
                        <div class="col-md-6 mb-3">

                            <label class="form-label">

                                Gambar Baru
                                <small class="text-muted">
                                    (Opsional)
                                </small>

                            </label>

                            <input type="file" id="edit_gambar" name="gambar" class="form-control"
                                accept=".jpg,.jpeg,.png">

                        </div>

                        {{-- PREVIEW --}}
                        <div class="col-md-12 text-center">

                            <img id="edit_previewGambar" src="" class="img-fluid rounded shadow"
                                style="
                                    display:none;
                                    max-height:250px;
                                ">

                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">

                        Batal

                    </button>

                    <button type="submit" class="btn btn-primary">

                        Update

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>
