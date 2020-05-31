<?php

namespace App\Repositories;

use App\Models\Folder;

class FolderRepository implements FolderRepositoryInterface
{
    public function index()
    {
        return Folder::select('id', 'name', 'slug')->get();
    }

    public function store($data)
    {
        return Folder::create($data);
    }

    public function destroy($folder)
    {
        return $folder->delete();
    }
}
