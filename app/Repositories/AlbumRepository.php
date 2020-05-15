<?php

namespace App\Repositories;

use App\Models\Album;
use Auth;

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
                    'category' => $album->category->name
                ];
            });
    }
}
