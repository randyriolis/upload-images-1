<?php

namespace App\Repositories;

interface AlbumRepositoryInterface
{
    public function index();

    public function store($data);

    public function destroy($id);

    public function firstOrFail($id);

    public function getPathAlbum($id);

    public function getByCategoryId($id);
}
