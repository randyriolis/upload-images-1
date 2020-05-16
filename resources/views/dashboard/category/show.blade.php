@extends('layouts.sbAdmin2.app')

@section('title', $category->name)

@section('head')
    <meta name="category-id" content="{{ $category->id }}">
    <script src="{{ mix('js/dashboard/category/show.js') }}" defer></script>
@endsection

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">{{ $category->name }}</h1>
<div class="row mb-2">
    <div class="col text-left">
        <a href="{{ route('dashboard.categories.index') }}" class="btn btn-secondary btn-icon-split">
            <span class="icon text-white-50">
                <i class="fas fa-arrow-left"></i>
            </span>
            <span class="text">Back</span>
        </a>
    </div>
    <div class="col text-right">
        <button class="btn btn-primary" data-toggle="modal" data-target="#album-tambah-modal">Add Album</button>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Images</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="album-tambah-modal" tabindex="-1" role="dialog" aria-labelledby="album-tambah-modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="needs-validation" novalidate>
            @csrf
            <input type="hidden" name="category_id" value="{{ $category->id }}">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Album</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="album-tambah-title">Judul</label>
                        <input type="text" class="form-control" id="album-tambah-title" name="title" pattern="[A-Za-z0-9-_. ]+" required>
                        <small class="form-text text-muted">Karakter yang diperbolehkan adalah a-z, A-Z, 0-9, titik (.), underscore (_), tanda pisah (-), dan spasi</small>
                        <div class="invalid-feedback">
                            Data tidak boleh kosong
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="album-hapus-modal" tabindex="-1" role="dialog" aria-labelledby="album-hapus-modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="needs-validation" novalidate>
            @csrf
            <input type="hidden" name="id" id="album-hapus-id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Album</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        Apakah Anda yakin akan menghapus album <strong></strong>?. Menghapus album akan menghapus semua foto yang ada di dalamnya.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Hapus</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection