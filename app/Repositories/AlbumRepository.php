<?php

namespace App\Repositories;

use App\Models\Album;
use Illuminate\Support\Str;

class AlbumRepository implements AlbumRepositoryInterface
{
    public function index()
    {
        return Album::with('category')
            ->withcount('images')
            ->get()
            ->map(function ($album) {
                return [
                    'id' => $album->id,
                    'title' => $album->title,
                    'images_count' => $album->images_count,
                    'category' => $album->category->name
                ];
            });
    }

    public function store($data)
    {
        $data['folder'] = Str::uuid();

        return Album::create($data);
    }

    public function update($folder, $id)
    {
        return Album::whereId($id)->update([
            'folder' => $folder
        ]);
    }

    public function destroy($id)
    {
        $album = $this->firstOrFail($id);

        return $album->delete();
    }

    /**
     * Get album berdasarkan id dan user yang sedang login
     * 
     * @param   int id
     * @return  App\Models\Album
     */
    public function firstOrFail($id)
    {
        return Album::whereId($id)->firstOrFail();
    }

    /**
     * Get path album
     */
    public function getPathAlbum($id)
    {
        return Album::select('name', 'title')
            ->where('albums.id', $id)
            ->join('categories', 'category_id', 'categories.id')
            ->firstOrFail();
    }
}
