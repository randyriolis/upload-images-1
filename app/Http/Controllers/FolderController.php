<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use App\Repositories\FolderRepositoryInterface;
use DataTables;
use Illuminate\Http\Request;

class FolderController extends Controller
{
    private $folderRepository;

    public function __construct(FolderRepositoryInterface $folderRepository) {
        $this->folderRepository = $folderRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! request()->ajax()) {
            return view('dashboard.folder.index');
        }

        $folders = $this->folderRepository->index();

        return DataTables::of($folders)->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Folder  $folder
     * @return \Illuminate\Http\Response
     */
    public function destroy(Folder $folder)
    {
        //
    }
}
