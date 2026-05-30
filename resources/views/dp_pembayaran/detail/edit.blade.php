<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog">

        <div class="modal-content">

            {{-- ========================= --}}
            {{-- HEADER --}}
            {{-- ========================= --}}
            <div class="modal-header">

                <h5 class="modal-title">
                    Edit Detail Pembayaran
                </h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>

            </div>

            {{-- ========================= --}}
            {{-- BODY --}}
            {{-- ========================= --}}
            <div class="modal-body">

                <form id="formEdit" method="POST" enctype="multipart/form-data" data-modal-id="#editModal">

                    @csrf

                    @method('PUT')

                    {{-- ========================= --}}
                    {{-- TANGGAL BAYAR --}}
                    {{-- ========================= --}}
                    <div class="mb-3">

                        <label for="edit_tanggal_bayar" class="form-label">

                            Tanggal Bayar

                        </label>

                        <input type="date" class="form-control" id="edit_tanggal_bayar" name="tanggal_bayar"
                            required>

                    </div>

                    {{-- ========================= --}}
                    {{-- JUMLAH --}}
                    {{-- ========================= --}}
                    <div class="mb-3">

                        <label for="edit_jumlah" class="form-label">

                            Jumlah Pembayaran

                        </label>

                        <div class="input-group">

                            <span class="input-group-text bg-light text-muted">

                                Rp

                            </span>

                            <input type="number" class="form-control" id="edit_jumlah" name="jumlah"
                                placeholder="Masukkan jumlah pembayaran" required>

                        </div>

                    </div>

                    {{-- ========================= --}}
                    {{-- KETERANGAN --}}
                    {{-- ========================= --}}
                    <div class="mb-3">

                        <label for="edit_keterangan" class="form-label">

                            Keterangan

                        </label>

                        <textarea class="form-control" id="edit_keterangan" name="keterangan" rows="3"
                            placeholder="Masukkan keterangan pembayaran"></textarea>

                    </div>

                    {{-- ========================= --}}
                    {{-- FOTO --}}
                    {{-- ========================= --}}
                    <div class="mb-3">
                        <label class="form-label">Bukti Pembayaran</label>
                        <input type="file" class="form-control" name="gambar" id="edit_gambar">
                        <div class="mt-2">
                            <p class="small text-muted">Bukti saat ini: </p>
                            <img id="edit_previewGambar" src="" style="max-width:100px; border-radius:6px;">
                        </div>
                    </div>

                    {{-- ========================= --}}
                    {{-- PREVIEW FOTO --}}
                    {{-- ========================= --}}
                    <div class="mb-3 text-center">

                        <img id="edit_previewFoto" src="" class="img-fluid rounded shadow-sm border"
                            style="max-height: 200px; display: none;">

                    </div>

                    {{-- ========================= --}}
                    {{-- FOOTER --}}
                    {{-- ========================= --}}
                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary btn-xs" data-bs-dismiss="modal">

                            Close

                        </button>

                        <button type="submit" class="btn btn-primary btn-xs">

                            Update

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>
