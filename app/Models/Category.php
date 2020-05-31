<?php

namespace App\Models;

use App\Models\Album;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];

    public function albums()
    {
        return $this->hasMany(Album::class);
    }

    public function folder()
    {
        $this->belongsTo(Folder::class);
    }
}
