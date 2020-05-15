<?php

namespace App\Http\Controllers;

use App\Repositories\AlbumRepositoryInterface;
use App\Repositories\ImageRepositoryInterface;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Storage;

class ImageController extends Controller
{
    private $imageRepository;
    private $albumRepository;

    public function __construct(ImageRepositoryInterface $imageRepository, AlbumRepositoryInterface $albumRepository)
    {
        $this->imageRepository = $imageRepository;
        $this->albumRepository = $albumRepository;
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
        $data = [];
        
        foreach ($request->file('image') as $key => $value) {
            $imageName = Str::uuid() . '.' . $value->getClientOriginalExtension();

            $data[$key] = [
                'album_id' => $album->id,
                'path' => $value->storeAs($album->folder, $imageName),
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString()
            ];
        }

        return $this->imageRepository->store($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
        $newFolder = Str::uuid();

        $data = [
            'folder' => $newFolder
        ];

        $success = $this->albumRepository->update($data, $albumId);

        if (! $success) {
            return abort(500);
        }

        $images = $this->imageRepository->index($albumId);
        $oldFolder = null;
        $data = [];

        foreach ($images as $key => $value) {
            $newImageName = $newFolder . '/' . Str::uuid() . '.' . pathinfo($value->path, PATHINFO_EXTENSION);
            
            try {
                Storage::move($value->path, $newImageName);
                $oldFolder = pathinfo($value->path, PATHINFO_DIRNAME);
            } catch (\Throwable $th) {}

            $data[$value->id] = $newImageName;
        }

        if ($oldFolder) {
            Storage::deleteDirectory($oldFolder);
        }

        return $this->imageRepository->regenerate($data);
    }
}
