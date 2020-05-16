<?php

namespace App\Http\Controllers;

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
    public function store(Request $request)
    {
        $data = $request->validate([
            'album_id' => 'required|integer',
            'image.*' => 'image'
        ], [
            'image' => 'Format file tidak didukung.'
        ]);

        $album = $this->albumRepository->firstOrFail($request->album_id);
        $category = $this->categoryRepository->firstOrFail($album->category_id);
        $data = [];
        
        foreach ($request->file('image') as $key => $value) {
            $imageName = Str::uuid() . '.' . $value->getClientOriginalExtension();
            $path = "$category->slug/$album->slug/$album->folder";

            $data[$key] = [
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
        $category = $this->categoryRepository->firstOrFail($album->category_id);
        $data = [];
        $newAlbumPath = "$category->slug/$album->slug/$album->folder";

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
}
