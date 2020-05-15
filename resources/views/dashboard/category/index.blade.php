@extends('layouts.sbAdmin2.app')

@section('title', 'Categories')

@section('head')
    <script src="{{ mix('js/dashboard/category/index.js') }}" defer></script>
@endsection

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Categories</h1>
<div class="row mb-2">
    <div class="col text-right">
        <button class="btn btn-primary" data-toggle="modal" data-target="#kategori-tambah-modal">Add Category</button>
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
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="kategori-tambah-modal" tabindex="-1" role="dialog" aria-labelledby="kategori-tambah-modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="needs-validation" novalidate>
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kategori</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="kategori-tambah-nama">Nama</label>
                        <input type="text" class="form-control" id="kategori-tambah-nama" name="name" required>
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

<div class="modal fade" id="kategori-edit-modal" tabindex="-1" role="dialog" aria-labelledby="kategori-edit-modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="needs-validation" novalidate>
            @csrf
            <input type="hidden" name="id" id="kategori-edit-id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Kategori</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="kategori-edit-nama">Nama</label>
                        <input type="text" class="form-control" id="kategori-edit-nama" name="name" required>
                        <div class="invalid-feedback">
                            Data tidak boleh kosong
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection