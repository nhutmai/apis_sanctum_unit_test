<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{

    public function index()
    {
        return Book::all();
    }

    public function show($id)
    {
        return Book::find($id);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'price' => 'required|numeric',
        ]);

        return Book::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $book = Book::find($id);

        $request->validate([
            'title' => 'sometimes|required',
            'author' => 'sometimes|required',
            'price' => 'sometimes|required|numeric',
        ]);

        $book->update($request->all());
        return $book;
    }

    public function destroy($id)
    {
        return Book::destroy($id);
    }

    public function search($title)
    {
        return Book::where('title', 'like', '%' . $title . '%')->get();
    }

    public function filter($author)
    {
        return Book::where('author', 'like', '%' . $author . '%')->get();
    }
}
