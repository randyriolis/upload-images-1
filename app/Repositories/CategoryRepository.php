<?php

namespace App\Repositories;

use App\Models\Category;
use Auth;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function index()
    {
        return Category::select('id', 'name')->get();
    }

    public function store($data)
    {
        $data['user_id'] = Auth::id();

        return Category::create($data);
    }

    public function update($data, $id)
    {
        $category = Category::where([
                'id' => $id,
                'user_id' => Auth::id()
            ])
            ->firstOrFail();

        return $category->update($data);
    }
}
