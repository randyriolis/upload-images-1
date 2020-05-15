@extends('layouts.sbAdmin2.app')

@section('title', 'Albums')

@section('head')
    <script src="{{ mix('js/dashboard/album/index.js') }}" defer></script>
@endsection

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Albums</h1>
<div class="row mb-2">
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
                                <th>Category</th>
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
                        <input type="text" class="form-control" id="album-tambah-title" name="title" required>
                        <div class="invalid-feedback">
                            Data tidak boleh kosong
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="album-tambah-category">Kategori</label>
                        <select class="custom-select" id="album-tambah-category" name="category_id" required>
                            <option value="">Pilih Kategori</option>
                            @foreach ($categories as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
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
@endsection