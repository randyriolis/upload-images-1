<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegenerateRequest;
use App\Repositories\AlbumRepositoryInterface;
use App\Repositories\CategoryRepositoryInterface;
use App\Repositories\ImageRepositoryInterface;
use Illuminate\Support\Str;
use Storage;
use Yajra\DataTables\DataTables;

class RegenerateController extends Controller
{
    private $categoryRepository;
    private $albumRepository;
    private $imageRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository,
        AlbumRepositoryInterface $albumRepository,
        ImageRepositoryInterface $imageRepository) {
        $this->categoryRepository = $categoryRepository;
        $this->albumRepository = $albumRepository;
        $this->imageRepository = $imageRepository;
    }

    public function category()
    {
        if (! request()->ajax()) {
            return view('dashboard.regenerate.category');
        }

        $categories = $this->categoryRepository->index();

        return DataTables::of($categories)->make(true);
    }

    public function categoryPost(RegenerateRequest $request)
    {
        $request->validated();

        $albums = $this->albumRepository->getByCategoryId(request()->category_id);
        $category = $this->categoryRepository->getWithFolder(request()->category_id);
        $data = [];
        $path = "$category->category_slug";

        if ($category->folder_slug) {
            $path = "$category->folder_slug/$path";
        }

        foreach ($albums as $album) {
            foreach ($album->images as $image) {
                $newImagePath = "$path/$album->slug/" . Str::uuid() . '.' . pathinfo($image->path, PATHINFO_EXTENSION);
    
                try {
                    Storage::move($image->path, $newImagePath);
                } catch (\Throwable $th) {}
    
                $data[$image->id] = $newImagePath;
            }
        }

        return $this->imageRepository->regenerate($data);
    }
}
