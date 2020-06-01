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
        
        foreach ($request->file('image') as $key => $value) {
            $imageName = Str::uuid() . '.' . $value->getClientOriginalExtension();
            $path = "$category->category_slug/$album->slug/$album->folder";

            if ($category->folder_slug) {
                $path = "$category->folder_slug/$path";
            }

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
        $oldAlbum = $this->albumRepository->firstOrFail($albumId);
        $success = $this->albumRepository->update(Str::uuid(), $albumId);

        if (! $success) {
            return abort(500);
        }

        $images = $this->imageRepository->index($albumId);
        $album = $this->albumRepository->firstOrFail($albumId);
        $category = $this->categoryRepository->getWithFolder($album->category_id);
        $data = [];
        $newAlbumPath = "$category->category_slug/$album->slug/$album->folder";

        if ($category->folder_slug) {
            $newAlbumPath = "$category->folder_slug/$newAlbumPath";
        }

        foreach ($images as $key => $value) {
            $newImagePath = "$newAlbumPath/" . Str::uuid() . '.' . pathinfo($value->path, PATHINFO_EXTENSION);

            try {
                Storage::move($value->path, $newImagePath);
            } catch (\Throwable $th) {}

            $data[$value->id] = $newImagePath;
        }

        Storage::deleteDirectory("$category->slug/$oldAlbum->slug/$oldAlbum->folder");

        return $this->imageRepository->regenerate($data);
    }

    public function storeByPath(ImageRequest $request)
    {
        $data = $request->validated();

        $paths = preg_replace('/\n$/', '', preg_replace('/^\n/', '', preg_replace('/[\r\n]+/', "\n", $data['path'])));
        $paths = explode("\n", $paths);

        $album = $this->albumRepository->firstOrFail($data['album_id']);
        $category = $this->categoryRepository->getWithFolder($album->category_id);
        $fullPath = "$category->category_slug/$album->slug/$album->folder";
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
