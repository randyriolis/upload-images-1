<?php

namespace App\Http\Controllers;

use App\Repositories\CategoryRepositoryInterface;
use DataTables;
use Illuminate\Http\Request;
use Storage;

class CategoryController extends Controller
{
    private $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (! $request->ajax()) {
            return view('dashboard.category.index');
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
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|unique:categories|regex:/^[A-Za-z0-9._\s-]+$/'
        ], [
            'regex' => 'Karakter yang diperbolehkan adalah a-z, A-Z, 0-9, titik (.), underscore (_), tanda pisah (-), dan spasi',
            'unique' => 'Nama sudah ada'
        ]);

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
