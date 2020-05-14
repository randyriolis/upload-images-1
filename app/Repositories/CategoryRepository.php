<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function index()
    {
        return Category::select('name')->get();
    }
}
