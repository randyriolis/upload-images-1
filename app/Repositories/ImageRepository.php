<?php

namespace App\Repositories;

use App\Models\Image;
use Auth;

class ImageRepository implements ImageRepositoryInterface
{
    public function index($albumId)
    {
        return Image::select('images.id', 'path')
            ->where([
                'album_id' => $albumId,
                'user_id' => Auth::id()
            ])
            ->join('albums', 'album_id', 'albums.id')
            ->get();
    }
}
