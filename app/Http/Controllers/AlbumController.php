<?php

namespace App\Http\Controllers;

use App\Repositories\AlbumRepositoryInterface;
use App\Repositories\CategoryRepositoryInterface;
use DataTables;
use Illuminate\Http\Request;
use Storage;

class AlbumController extends Controller
{
    private $albumRepository;
    private $categoryRepository;

    public function __construct(AlbumRepositoryInterface $albumRepository, CategoryRepositoryInterface $categoryRepository)
    {
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
        if (! request()->ajax()) {
            $categories = $this->categoryRepository->getIdName();

            return view('dashboard.album.index', compact('categories'));
        }

        $albums = $this->albumRepository->index();

        return DataTables::of($albums)->make(true);
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
            'title' => 'required|unique:albums|regex:/^[A-Za-z0-9._\s-]+$/',
            'category_id' => 'required|integer'
        ], [
            'regex' => 'Karakter yang diperbolehkan adalah a-z, A-Z, 0-9, titik (.), underscore (_), tanda pisah (-), dan spasi',
            'unique' => 'Nama sudah ada'
        ]);

        return $this->albumRepository->store($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $album = $this->albumRepository->firstOrFail($id);

        return view('dashboard.album.show', compact('album'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $album = $this->albumRepository->getPathAlbum($id);
        $isDeleted = $this->albumRepository->destroy($id);

        if ($isDeleted) {
            return Storage::deleteDirectory("$album->category_slug/$album->album_slug");
        }
    }
}
