<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageRequest;
use App\Repositories\AlbumRepositoryInterface;
use App\Repositories\CategoryRepositoryInterface;
use App\Repositories\ImageRepositoryInterface;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Storage;

class ImageController extends Controller
{
    private $imageRepository;
    private $albumRepository;
    private $categoryRepository;

    public function __construct(ImageRepositoryInterface $imageRepository, AlbumRepositoryInterface $albumRepository, CategoryRepositoryInterface $categoryRepository)
    {
        $this->imageRepository = $imageRepository;
        $this->albumRepository = $albumRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $images = $this->imageRepository->index(request()->album_id);

        return DataTables::of($images)->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ImageRequest $request)
    {
        $data = $request->validated();

        $album = $this->albumRepository->firstOrFail($request->album_id);
        $category = $this->categoryRepository->getWithFolder($album->category_id);
        $maxNoUrut = $this->imageRepository->getMaxNoUrut($album->id);
        $data = [];
        $path = "$category->category_slug/$album->slug";

        if ($category->folder_slug) {
            $path = "$category->folder_slug/$path";
        }
        
        foreach ($request->file('image') as $key => $value) {
            $imageName = Str::uuid() . '.' . $value->getClientOriginalExtension();

            $data[$key] = [
                'no_urut' => $maxNoUrut + $key + 1,
                'album_id' => $album->id,
                'path' => $value->storeAs($path, $imageName),
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString()
            ];
        }

        return $this->imageRepository->store($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $path = $this->imageRepository->destroy($id);

        if ($path) {
            return Storage::delete($path);
        }

        return abort(500);
    }

    /**
     * Regenerate nama folder dan image
     */
    public function regenerate($albumId)
    {
        $album = $this->albumRepository->firstOrFail($albumId);
        $category = $this->categoryRepository->getWithFolder($album->category_id);
        $data = [];
        $path = "$category->category_slug";

        if ($category->folder_slug) {
            $path = "$category->folder_slug/$path";
        }

        foreach ($album->images as $image) {
            $newImagePath = "$path/$album->slug/" . Str::uuid() . '.' . pathinfo($image->path, PATHINFO_EXTENSION);

            try {
                Storage::move($image->path, $newImagePath);
            } catch (\Throwable $th) {}

            $data[$image->id] = $newImagePath;
        }

        return $this->imageRepository->regenerate($data);
    }

    public function storeByPath(ImageRequest $request)
    {
        $data = $request->validated();

        $paths = preg_replace('/\n$/', '', preg_replace('/^\n/', '', preg_replace('/[\r\n]+/', "\n", $data['path'])));
        $paths = explode("\n", $paths);

        $album = $this->albumRepository->firstOrFail($data['album_id']);
        $category = $this->categoryRepository->getWithFolder($album->category_id);
        $fullPath = "$category->category_slug/$album->slug";
        $maxNoUrut = $this->imageRepository->getMaxNoUrut($data['album_id']);
        $data = [];

        if ($category->folder_slug) {
            $fullPath = "$category->folder_slug/$fullPath";
        }

        foreach ($paths as $key => $value) {
            $data[$key] = [
                'no_urut' => $maxNoUrut + $key + 1,
                'album_id' => $request->album_id,
                'path' => "$fullPath/$value",
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString()
            ];
        }

        return $this->imageRepository->store($data);
    }
}
