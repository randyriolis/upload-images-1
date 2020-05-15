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
        <button class="btn btn-primary">Add Image</button>
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
@endsection