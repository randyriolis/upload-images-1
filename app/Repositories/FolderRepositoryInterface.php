<?php

namespace App\Repositories;

interface FolderRepositoryInterface
{
    public function index();

    public function store($data);
}
