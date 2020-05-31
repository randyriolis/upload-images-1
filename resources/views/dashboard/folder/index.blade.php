@extends('layouts.sbAdmin2.app')

@section('title', 'Folders')

@section('head')
    <script src="{{ mix('js/dashboard/folder/index.js') }}" defer></script>
@endsection

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Folders</h1>
<div class="row mb-2">
    <div class="col text-right">
        <button class="btn btn-primary">Add Folder</button>
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
@endsection