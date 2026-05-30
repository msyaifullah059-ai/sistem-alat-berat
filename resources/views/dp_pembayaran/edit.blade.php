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
                        <label for="edit_transaksi_sewa_id" class="form-label">Transaksi Alat Berjalan</label>
                        <select class="form-select" id="edit_transaksi_sewa_id" name="transaksi_sewa_id" required>
                            <option value="">-- Pilih Transaksi --</option>
                            @foreach ($transaksi as $row)
                                {{-- Kita tampilin Nama Pelanggan & Nama Alat biar user gak bingung --}}
                                <option value="{{ $row->id }}">
                                    {{ $row->pelanggan->nama }} | {{ $row->alat->nama_alat }}
                                    ({{ $row->lokasi_proyek }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status" id="edit_status">
                            <option value="Belum Lunas">Belum Lunas</option>
                            <option value="Lunas">Lunas</option>
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
