@extends('index')

@section('title', 'Edit About')

@section('content')

    <div class="page-heading">
        <section id="content-types">
            <div class="row">
                <div class="col-xl-12 col-md-6 col-sm-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <form class="form" method="POST" action="{{ route('about.edit', $about->id) }}"
                                    enctype="multipart/form-data">

                                    @csrf
                                    @method('POST')

                                    <div class="form-body">
                                        <div class="form-group">
                                            <label for="deskripsi" class="sr-only">Deskripsi</label>
                                            <textarea id="deskripsi" name="deskripsi" class="form-control" rows="5">{{ old('deskripsi', $about->deskripsi) }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="gambar" class="sr-only">Gambar</label>
                                            @if ($about->gambar)
                                                <div>
                                                    <img src="{{ url('storage/' . $about->gambar) }}" alt="Gambar"
                                                        width="150" class="mb-3">
                                                </div>
                                            @endif
                                            <input type="file" id="gambar" name="gambar" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-actions d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">Update</button> &nbsp;
                                        <a href="{{ route('about.index') }}" class="btn btn-secondary">Cancel</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection
