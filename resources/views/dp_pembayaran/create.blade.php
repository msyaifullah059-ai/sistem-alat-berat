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
                <form id="formTambah" class="forms-sample ajax-form" action="{{ route('dp_pembayaran.store') }}"
                    method="POST" enctype="multipart/form-data" data-modal-id="#createModal">
                    @csrf

                    <div class="mb-3">
                        <label for="transaksi_sewa_id" class="form-label">Transaksi Alat Berjalan</label>
                        <select class="form-select" id="transaksi_sewa_id" name="transaksi_sewa_id" required>
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
                        <label for="tanggal" class="form-label">Tanggal Kerja</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" required />
                    </div>
                    <div class="mb-3">
                        <label for="jumlah" class="form-label">Jumlah</label>
                        <input type="number" class="form-control" id="jumlah" name="jumlah" placeholder="Jumlah"
                            required />
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Keterangan"
                            required />
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
