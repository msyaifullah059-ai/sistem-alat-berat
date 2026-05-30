<!-- Modal -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">

    <div class="modal-dialog">

        <div class="modal-content">

            {{-- ========================= --}}
            {{-- HEADER --}}
            {{-- ========================= --}}
            <div class="modal-header">

                <h5 class="modal-title" id="createModalLabel">

                    Tambah Detail Pembayaran

                </h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close">
                </button>

            </div>

            {{-- ========================= --}}
            {{-- BODY --}}
            {{-- ========================= --}}
            <div class="modal-body">

                <form id="formTambah" class="forms-sample"
                    action="{{ route('dp_pembayaran.detail_dp_pembayaran.store', $dp_pembayaran) }}" method="POST"
                    enctype="multipart/form-data" data-modal-id="#createModal">

                    @csrf

                    {{-- ========================= --}}
                    {{-- DP PEMBAYARAN ID --}}
                    {{-- ========================= --}}
                    <input type="hidden" name="dp_pembayaran_id" value="{{ $pembayaran->id }}">

                    {{-- ========================= --}}
                    {{-- TANGGAL BAYAR --}}
                    {{-- ========================= --}}
                    <div class="mb-3">

                        <label for="tanggal_bayar" class="form-label">

                            Tanggal Bayar

                        </label>

                        <input type="date" class="form-control" id="tanggal_bayar" name="tanggal_bayar" required>

                    </div>

                    {{-- ========================= --}}
                    {{-- JUMLAH --}}
                    {{-- ========================= --}}
                    <div class="mb-3">

                        <label for="jumlah" class="form-label">

                            Jumlah Pembayaran

                        </label>

                        <div class="input-group">

                            <span class="input-group-text bg-light text-muted">

                                Rp

                            </span>

                            <input type="number" class="form-control" id="jumlah" name="jumlah"
                                placeholder="Masukkan jumlah pembayaran" required>

                        </div>

                    </div>

                    {{-- ========================= --}}
                    {{-- KETERANGAN --}}
                    {{-- ========================= --}}
                    <div class="mb-3">

                        <label for="keterangan" class="form-label">

                            Keterangan

                        </label>

                        <textarea class="form-control" id="keterangan" name="keterangan" rows="3"
                            placeholder="Masukkan keterangan pembayaran"></textarea>

                    </div>

                    {{-- ========================= --}}
                    {{-- FOTO --}}
                    {{-- ========================= --}}
                    {{-- <div class="mb-3">

                        <label for="gambar" class="form-label">

                            Bukti Pembayaran

                        </label>

                        <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*">

                    </div> --}}
                    <div class="mb-3">
                        <label class="form-label" for="gambar">Bukti Pembayaran</label>

                        <input class="form-control" type="file" id="gambar" name="gambar" accept="image/*" />

                        <div class="mt-2">
                            <img id="previewGambar" src="" alt="Preview"
                                style="max-width:120px; display:none; border-radius:6px;">
                        </div>
                    </div>

                    {{-- ========================= --}}
                    {{-- PREVIEW FOTO --}}
                    {{-- ========================= --}}
                    <div class="mb-3 text-center">

                        <img id="previewFoto" src="" class="img-fluid rounded shadow-sm border"
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

                            Simpan

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>
