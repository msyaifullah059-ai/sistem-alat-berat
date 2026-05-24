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
                <form id="formTambah" class="forms-sample ajax-form" action="{{ route('pricing.store') }}"
                    method="POST" enctype="multipart/form-data" data-modal-id="#createModal">
                    @csrf

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
                        <label class="form-label fw-bold">Jenis Pekerjaan</label>

                        <!-- BAKET -->
                        <div class="form-check mb-2">
                            <input class="form-check-input pekerjaan-checkbox" type="checkbox" value="baket"
                                id="baket" name="jenis_pekerjaan[]">

                            <label class="form-check-label" for="baket">
                                Baket
                            </label>
                        </div>

                        <!-- FORM BAKET -->
                        <div id="form-baket" class="row d-none mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Harga Sewa/Hari Baket</label>

                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted">Rp</span>

                                    <input type="number" class="form-control" name="harga_sewa_hari_baket"
                                        placeholder="0">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Harga Sewa/Jam Baket</label>

                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted">Rp</span>

                                    <input type="number" class="form-control" name="harga_sewa_jam_baket"
                                        placeholder="0">
                                </div>
                            </div>
                        </div>

                        <!-- BREKER -->
                        <div class="form-check mb-2">
                            <input class="form-check-input pekerjaan-checkbox" type="checkbox" value="breker"
                                id="breker" name="jenis_pekerjaan[]">

                            <label class="form-check-label" for="breker">
                                Breker
                            </label>
                        </div>

                        <!-- FORM BREKER -->
                        <div id="form-breker" class="row d-none mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Harga Sewa/Hari Breker</label>

                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted">Rp</span>

                                    <input type="number" class="form-control" name="harga_sewa_hari_breker"
                                        placeholder="0">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Harga Sewa/Jam Breker</label>

                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted">Rp</span>

                                    <input type="number" class="form-control" name="harga_sewa_jam_breker"
                                        placeholder="0">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="berlaku_mulai" class="form-label">Berlaku mulai</label>
                        <input type="date" class="form-control" id="berlaku_mulai" name="berlaku_mulai"
                            placeholder="Berlaku mulai" required />
                    </div>
                    <div class="mb-3">
                        <label for="berlaku_selesai" class="form-label">Berlaku Selesai</label>
                        <input type="date" class="form-control" id="berlaku_selesai" name="berlaku_selesai"
                            placeholder="Berlaku Selesai" required />
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

<script>
    const baketCheckbox = document.getElementById('baket');
    const brekerCheckbox = document.getElementById('breker');

    const formBaket = document.getElementById('form-baket');
    const formBreker = document.getElementById('form-breker');

    // Toggle BAKET
    baketCheckbox.addEventListener('change', function() {

        if (this.checked) {
            formBaket.classList.remove('d-none');
        } else {
            formBaket.classList.add('d-none');
        }

    });

    // Toggle BREKER
    brekerCheckbox.addEventListener('change', function() {

        if (this.checked) {
            formBreker.classList.remove('d-none');
        } else {
            formBreker.classList.add('d-none');
        }

    });
</script>
