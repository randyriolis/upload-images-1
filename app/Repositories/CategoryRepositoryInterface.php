<?php

namespace App\Repositories;

interface CategoryRepositoryInterface
{
    public function index();

    public function store($data);

    public function destroy($id);

    public function getIdName();

    public function firstOrFail($id);
    
    public function getWithFolder($id);
}
