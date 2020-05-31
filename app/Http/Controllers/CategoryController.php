<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Repositories\CategoryRepositoryInterface;
use App\Repositories\FolderRepositoryInterface;
use DataTables;
use Illuminate\Http\Request;
use Storage;

class CategoryController extends Controller
{
    private $categoryRepository;
    private $folderRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository, FolderRepositoryInterface $folderRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->folderRepository = $folderRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (! $request->ajax()) {
            $folders = $this->folderRepository->index();

            return view('dashboard.category.index', compact('folders'));
        }

        $categories = $this->categoryRepository->index();

        return DataTables::of($categories)->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $data = $request->validated();

        return $this->categoryRepository->store($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = $this->categoryRepository->firstOrFail($id);

        return view('dashboard.category.show', compact('category'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = $this->categoryRepository->firstOrFail($id);
        $isDeleted = $this->categoryRepository->destroy($id);

        if ($isDeleted) {
            return Storage::deleteDirectory($category->slug);
        }
    }
}
