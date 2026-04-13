<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 15px; overflow: hidden;">
            <div class="modal-header border-0 pb-0" style="background: #f8fafc;">
                <div class="d-flex align-items-center">
                    <div class="bg-primary p-2 rounded-3 me-3 text-white">
                        <i class="mdi mdi-information-variant mdi-24px"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold text-dark mb-0" id="detailModalLabel text-uppercase"
                            style="letter-spacing: 1px;">Detail Transaksi Sewa</h5>
                        <small class="text-muted">ID : </small>
                        <small class="text-muted" id="det_id_transaksi"></small>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4" style="background: #f8fafc;">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                            <div class="card-body">
                                <h6 class="fw-bold text-primary mb-3"><i class="mdi mdi-account-tie me-2"></i>Informasi
                                    Penyewa</h6>
                                <div class="mb-2">
                                    <label class="text-muted fw-bold">Penyewa : </label>
                                    <span class="text-dark" id="det_pelanggan"></span>
                                </div>
                                <div class="mb-2">
                                    <label class="text-muted fw-bold">Lokasi Proyek : </label>
                                    <span id="det_lokasi" class="text-dark"></span>
                                </div>
                                <div class="mb-0">
                                    <label class="text-muted fw-bold">Tanggal Sewa : </label>
                                    <span id="det_tanggal" class="badge bg-light text-dark border p-2"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                            <div class="card-body">
                                <h6 class="fw-bold text-info mb-3"><i class="mdi mdi-crane me-2"></i>Detail Unit</h6>
                                <div class="mb-2">
                                    <label class="text-muted fw-bold">Alat Berat : </label>
                                    <span class="text-dark" id="det_alat"></span>
                                </div>
                                <div class="mb-2">
                                    <label class="text-muted fw-bold">Operator : </label>
                                    <span id="det_operator" class="text-dark"></span>
                                </div>
                                <div class="mb-0">
                                    <label class="text-muted fw-bold">Status : </label>
                                    <div id="det_status"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card border-0 shadow-sm" style="border-radius: 12px; background: #ffffff;">
                            <div class="card-body p-0">
                                <div class="p-3 border-bottom bg-light" style="border-radius: 12px 12px 0 0;">
                                    <h6 class="fw-bold mb-0 text-dark"><i class="mdi mdi-cash-multiple me-2"></i>Rincian
                                        Biaya & Pekerjaan</h6>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <tbody style="font-size: 0.9rem;">
                                            <tr>
                                                <td class="text-muted">Jenis Pekerjaan</td>
                                                <td class="text-end fw-bold" id="det_pekerjaan"></td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Sewa Baket / Breker</td>
                                                <td class="text-end fw-bold text-dark">
                                                    <span id="det_harga_baket"></span> / <span
                                                        id="det_harga_breker"></span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">Mobilisasi / Demo</td>
                                                <td class="text-end text-dark" id="det_mobdem"></td>
                                            </tr>
                                            <tr class="table-primary border-top-0">
                                                <td class="fw-bold">Biaya Modem (Opsional)</td>
                                                <td class="text-end fw-bold text-primary" id="det_biaya_modem"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer border-0 p-4" style="background: #f8fafc;">
                <button type="button" class="btn btn-light fw-bold" data-bs-dismiss="modal"
                    style="border-radius: 8px;">Tutup</button>

                <div class="ms-auto">
                    <a href="#" id="btn_surat_jalan" target="_blank"
                        class="btn btn-info btn-icon-text text-white fw-bold shadow-sm"
                        style="border-radius: 8px; background: #0ea5e9;">
                        <i class="mdi mdi-truck-delivery me-1"></i> Cetak Surat Jalan
                    </a>
                    <a href="#" id="btn_invoice" target="_blank"
                        class="btn btn-primary btn-icon-text fw-bold shadow-sm"
                        style="border-radius: 8px; background: #1e293b;">
                        <i class="mdi mdi-file-document-outline me-1"></i> Cetak Invoice
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
