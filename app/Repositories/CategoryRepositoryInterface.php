<?php

namespace App\Repositories;

interface CategoryRepositoryInterface
{
    public function index();

    public function store($data);

    public function update($data, $id);

    public function destroy($id);
}
