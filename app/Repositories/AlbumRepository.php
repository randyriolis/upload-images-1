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
}
