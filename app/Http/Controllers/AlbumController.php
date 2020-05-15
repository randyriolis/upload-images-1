<?php

namespace App\Http\Controllers;

use App\Repositories\AlbumRepositoryInterface;
use App\Repositories\CategoryRepositoryInterface;
use DataTables;
use Illuminate\Http\Request;

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
            'title' => 'required',
            'category_id' => 'required|integer'
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title' => 'required',
            'category_id' => 'required|integer'
        ]);

        return $this->albumRepository->update($data, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->albumRepository->destroy($id);
    }
}
