<?php

namespace App\Repositories;

use App\Models\Category;
use Auth;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function index()
    {
        return Category::select('id', 'name')->whereUserId(Auth::id())->withCount('albums')->get();
    }

    public function store($data)
    {
        $data['user_id'] = Auth::id();

        return Category::create($data);
    }

    public function update($data, $id)
    {
        $category = $this->firstOrFail($id);

        return $category->update($data);
    }

    public function destroy($id)
    {
        $category = $this->firstOrFail($id);

        return $category->delete();
    }

    /**
     * Get category berdasarkan id dan user yang sedang login
     * 
     * @param   int id
     * @return  App\Models\Category
     */
    private function firstOrFail($id)
    {
        return Category::where([
                'id' => $id,
                'user_id' => Auth::id()
            ])
            ->firstOrFail();
    }

    public function getIdName()
    {
        return Category::select('id', 'name')->whereUserId(Auth::id())->get();
    }
}
