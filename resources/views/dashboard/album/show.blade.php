@extends('layouts.sbAdmin2.app')

@section('title', $album->title)

@section('head')
    <meta name="album-id" content="{{ $album->id }}">
    <script src="{{ mix('js/dashboard/album/show.js') }}" defer></script>
@endsection

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">{{ $album->title }}</h1>
<div class="row mb-2">
    <div class="col text-left">
        <a href="{{ route('dashboard.albums.index') }}" class="btn btn-secondary btn-icon-split">
            <span class="icon text-white-50">
                <i class="fas fa-arrow-left"></i>
            </span>
            <span class="text">Back</span>
        </a>
    </div>
    <div class="col text-right">
        <button class="btn btn-primary" data-toggle="modal" data-target="#image-tambah-modal">Add Image</button>
        <button class="btn btn-warning">Regenerate URL</button>
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
                                <th>Image</th>
                                <th>Path</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="image-tambah-modal" tabindex="-1" role="dialog" aria-labelledby="image-tambah-modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="needs-validation" novalidate>
            @csrf
            <input type="hidden" name="album_id" value="{{ $album->id }}">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Gambar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label for="image-tambah-file">Choose Images</label>
                    <div class="custom-file mb-3">
                        <input type="file" name="image[]" class="custom-file-input" id="image-tambah-file" accept="image/*" multiple required>
                        <label class="custom-file-label" for="image-tambah-file">Choose images...</label>
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