<?php

namespace App\Repositories;

interface ImageRepositoryInterface
{
    public function index($albumId);

    public function store($data);

    public function destroy($id);

    public function regenerate($data);

    public function firstOrFail($id);
}
