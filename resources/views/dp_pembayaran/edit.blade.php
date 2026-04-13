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
                        <label for="edit_tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="edit_tanggal" name="tanggal" required />
                    </div>
                    <div class="mb-3">
                        <label for="edit_jumlah" class="form-label">Jumlah</label>
                        <input type="number" class="form-control" id="edit_jumlah" name="jumlah" placeholder="Jumlah"
                            required />
                    </div>
                    <div class="mb-3">
                        <label for="edit_keterangan" class="form-label">Keterangan</label>
                        <input type="text" class="form-control" id="edit_keterangan" name="keterangan"
                            placeholder="Keterangan" required />
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
