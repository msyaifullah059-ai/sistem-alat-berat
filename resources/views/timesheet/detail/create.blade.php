<div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form id="formTambah" action="{{ route('timesheet.detail_timesheet.store', $timesheet->id) }}" method="POST"
                enctype="multipart/form-data">

                @csrf

                <div class="modal-header">

                    <h5 class="modal-title">

                        Tambah Detail Timesheet

                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <input type="hidden" name="timesheet_id" value="{{ $timesheet->id }}">

                    <div class="row">

                        {{-- TANGGAL --}}
                        <div class="col-md-6 mb-3">

                            <label class="form-label">

                                Tanggal Pekerjaan

                            </label>

                            <input type="date" name="tanggal_pekerjaan" class="form-control" required>

                        </div>

                        {{-- JAM BAKET --}}
                        <div class="col-md-6 mb-3">

                            <label class="form-label">

                                Jam Baket

                            </label>

                            <input type="number" name="jam_baket" class="form-control" min="0" value="0">

                        </div>

                        {{-- HM AWAL --}}
                        <div class="col-md-6 mb-3">

                            <label class="form-label">

                                HM Awal

                            </label>

                            <input type="number" name="hm_awal" class="form-control" min="0" required>

                        </div>

                        {{-- HM AKHIR --}}
                        <div class="col-md-6 mb-3">

                            <label class="form-label">

                                HM Akhir

                            </label>

                            <input type="number" name="hm_akhir" class="form-control" min="0" required>

                        </div>

                        {{-- JAM BREKER --}}
                        <div class="col-md-6 mb-3">

                            <label class="form-label">

                                Jam Breker

                            </label>

                            <input type="number" name="jam_breker" class="form-control" min="0" value="0">

                        </div>

                        {{-- GAMBAR --}}
                        <div class="col-md-6 mb-3">

                            <label class="form-label">

                                Gambar

                            </label>

                            <input type="file" id="gambar" name="gambar" class="form-control"
                                accept=".jpg,.jpeg,.png">

                        </div>

                        {{-- PREVIEW --}}
                        <div class="col-md-12 text-center">

                            <img id="previewGambar" src="" class="img-fluid rounded shadow"
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

                        Simpan

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>
