@extends('index')

@section('title', 'About')

@section('content')

    <div class="page-heading">
        <section class="section">
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-5">
                                <div class="col-md-10">
                                    <p class="text-subtitle text-muted font-bold">List Data : </p>
                                </div>
                                <div class="col-md-2 d-flex justify-content-end">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#modal-add">
                                        <i class="fa fa-plus" aria-hidden="true"></i> Tambah
                                    </button>
                                </div>
                            </div>

                            <div class="row mb-5">
                                <div class="col-md-12 d-flex justify-content-start">
                                    <form action="{{ route('about.import') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label for="file">Pilih File Excel</label>
                                            <input type="file" name="file" class="form-control" required>
                                        </div>
                                        <button type="submit" class="btn btn-success">Impor Data</button>
                                    </form>
                                </div>
                            </div>

                            <table class="table table-striped" id="posts-table">
                                <thead>
                                    <tr>
                                        <th style="width: 5%">No</th>
                                        <th style="width: 40%">Deskripsi</th>
                                        <th style="width: 40%">Gambar</th>
                                        <th style="width: 15%">Aksi</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @include('about.add')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript">
        $(function() {
            $('#posts-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('about.index') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'deskripsi',
                        name: 'deskripsi'
                    },
                    {
                        data: 'gambar',
                        name: 'gambar',

                        render: function(data, type, row, meta) {
                            if (data) {
                                return '<img src="/storage/' + data +
                                    '" alt="Gambar" width="50" height="50">';
                            } else {
                                return '<img src="/storage/default-image.jpg" alt="Default Gambar" width="50" height="50">';
                            }
                        }

                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });
    </script>

@endsection
