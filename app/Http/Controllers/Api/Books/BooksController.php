<?php

namespace App\Http\Controllers\Api\Books;

use App\Book;
use App\Http\Resources\BookResource;
use App\Http\Requests\Book\BookStoreRequest;
use App\Http\Requests\Book\BookUpdateRequest;
use App\Http\Controllers\Controller;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return BookResource::collection(Book::with('categories')->paginate(25));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookStoreRequest $request)
    {
        try {
            $book = Book::create([
                'title' => $request->title,
                'description' => $request->description,
            ]);

            return new BookResource($book);

        } catch(\Exeception $exception) {
            return response([
                'status' => 'error',
                'message' => "Error: Book not created!, please try again. - {$exception->getMessage()}"
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
        $book = Book::findOrfail($id);

        return new BookResource($book);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BookUpdateRequest $request, Book $book)
    {
        try {

            $book->update($request->only(['title', 'description']));

            return new BookResource($book);

        } catch(\Exeception $exception) {
            return response([
                'status' => 'error',
                'message' => 'Error: Book not updated!, please try again. - {$exception->getMessage()}'
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
        $book = Book::findOrfail($id);
        $book->delete();

        return response()->json(null, 204);
    }
}