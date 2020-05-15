<?php

namespace App\Repositories;

use App\Models\Album;
use Auth;
use Illuminate\Support\Str;

class AlbumRepository implements AlbumRepositoryInterface
{
    public function index()
    {
        return Album::whereUserId(Auth::id())
            ->with('category')
            ->get()
            ->map(function ($album) {
                return [
                    'id' => $album->id,
                    'title' => $album->title,
                    'category_id' => $album->category_id,
                    'category' => $album->category->name
                ];
            });
    }

    public function store($data)
    {
        $data['user_id'] = Auth::id();
        $data['folder'] = Str::uuid();

        return Album::create($data);
    }

    public function update($data, $id)
    {
        $album = $this->firstOrFail($id);

        return $album->update($data);
    }

    /**
     * Get album berdasarkan id dan user yang sedang login
     * 
     * @param   int id
     * @return  App\Models\Album
     */
    private function firstOrFail($id)
    {
        return Album::where([
                'id' => $id,
                'user_id' => Auth::id()
            ])
            ->firstOrFail();
    }
}
