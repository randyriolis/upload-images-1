<?php

namespace App\Repositories;

use App\Models\Category;
use Auth;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function index()
    {
        return Category::select('name')->get();
    }

    public function store($data)
    {
        $data['user_id'] = Auth::id();

        return Category::create($data);
    }
}
