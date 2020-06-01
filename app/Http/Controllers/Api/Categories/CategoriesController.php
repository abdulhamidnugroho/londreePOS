<?php

namespace App\Http\Controllers\Api\Categories;

use App\Book;
use App\Category;
use App\Http\Resources\CategoryResource;
use App\Http\Requests\Category\CategoryStoreRequest;
use App\Http\Requests\Category\CategoryUpdateRequest;
use App\Http\Controllers\Controller;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CategoryResource::collection(Category::with('book')->paginate(25));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryStoreRequest $request)
    {
        try {
            $category = Category::firstOrCreate([
                'book_id' => $request->book_id,
                'name' => $request->name,
            ]);

            return new CategoryResource($category);

        } catch(\Exeception $exception) {
            return response([
                'status' => 'error',
                'message' => "Error: Category not created!, please try again. - {$exception->getMessage()}"
            ], 500);
        }
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::findOrfail($id);

        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryUpdateRequest $request, Category $category)
    {
        try {

            $category->update($request->only(['book_id', 'name']));

            return new CategoryResource($category);

        } catch(\Exeception $exception) {
            return response([
                'status' => 'error',
                'message' => "Error: Category not updated!, please try again. - {$exception->getMessage()}"
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Category::findOrfail($id);
        $book->delete();

        return response()->json(null, 204);
    }

}
