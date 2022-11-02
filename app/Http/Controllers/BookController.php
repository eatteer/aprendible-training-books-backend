<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Collection
     */
    public function index()
    {
        return Book::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Book
     */
    public function store(Request $request)
    {
        $book = $request->validate([
            'title' => 'required'
        ]);
        return Book::create($book);
    }

    /**
     * Display the specified resource.
     *
     * @param Book $book
     * @return Book
     */
    public function show(Book $book)
    {
        return $book;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Book $book
     * @return Book
     */
    public function update(Request $request, Book $book)
    {
        $updatedBook = $request->validate([
            'title' => 'required'
        ]);
        $book->update($updatedBook);
        return $book->refresh();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Book $book
     * @return Book
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return $book;
    }
}
