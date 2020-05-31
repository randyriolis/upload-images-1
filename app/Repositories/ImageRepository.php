<?php

namespace App\Repositories;

use App\Models\Image;

class ImageRepository implements ImageRepositoryInterface
{
    public function index($albumId)
    {
        return Image::select('id', 'no_urut', 'path')
            ->whereAlbumId($albumId)
            ->orderBy('no_urut')
            ->get();
    }

    public function store($data)
    {
        return Image::insert($data);
    }

    public function destroy($id)
    {
        $image = $this->firstOrFail($id);
        $path = $image->path;

        if ($image->delete()) {
            return $path;
        }

        return false;
    }

    public function regenerate($data)
    {
        foreach ($data as $key => $value) {
            Image::whereId($key)->update([
                'path' => $value
            ]);
        }

        return true;
    }

    /**
     * Get image berdasarkan id dan user yang sedang login
     * 
     * @param   int id
     * @return  App\Models\Image
     */
    public function firstOrFail($id)
    {
        return Image::select('id', 'path')
            ->whereId($id)
            ->firstOrFail();
    }

    public function getMaxNoUrut($albumId)
    {
        return Image::whereAlbumId($albumId)->max('no_urut');
    }
}
