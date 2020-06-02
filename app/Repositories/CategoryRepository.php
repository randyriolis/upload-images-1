<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function index()
    {
        return Category::select('categories.id', 'categories.name as category_name', 'categories.slug as category_slug', 'folders.name as folder_name', 'folders.slug as folder_slug')->withCount('albums')->leftJoin('folders', 'folder_id', 'folders.id')->get();
    }

    public function store($data)
    {
        return Category::create($data);
    }

    public function destroy($id)
    {
        return Category::whereId($id)->delete();
    }

    public function getIdName()
    {
        return Category::select('id', 'name')->get();
    }

    /**
     * Get category berdasarkan id
     * 
     * @param   int id
     * @return  App\Models\Category
     */
    public function firstOrFail($id)
    {
        return Category::whereId($id)->firstOrFail();
    }

    public function getWithFolder($id)
    {
        return Category::select('categories.slug as category_slug', 'folders.slug as folder_slug')->where('categories.id', $id)->leftJoin('folders', 'folder_id', 'folders.id')->firstOrFail();
    }
}
