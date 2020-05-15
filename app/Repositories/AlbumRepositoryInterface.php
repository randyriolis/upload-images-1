<?php

namespace App\Repositories;

interface AlbumRepositoryInterface
{
    public function index();

    public function store($data);

    public function update($data, $id);

    public function firstOrFail($id);
}
