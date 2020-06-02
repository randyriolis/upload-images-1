@extends('layouts.sbAdmin2.app')

@section('title', 'Regenerate by Category')

@section('head')
    <script src="{{ mix('js/dashboard/regenerate/category.js') }}" defer></script>
@endsection

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Regenerate by Category</h1>
<div class="row">
    <div class="col">
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Albums</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="image-regenerate-modal" tabindex="-1" role="dialog" aria-labelledby="image-regenerate-modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="needs-validation" novalidate>
            <input type="hidden" name="category_id" id="image-regenerate-id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Regenerate URL</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        Apakah Anda yakin akan memperbarui semua URL di kategori <strong></strong>?
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Yakin</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection