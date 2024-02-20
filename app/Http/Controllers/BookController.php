<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    // Create or update a book
    public function createOrUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'author' => 'required|string',
            'isbn' => 'required|string|unique:books,isbn',
            'published_date' => 'required|date'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $bookData = $request->only('name', 'author', 'isbn', 'published_date');
        $book = Book::updateOrCreate(['isbn' => $bookData['isbn']], $bookData);

        return response()->json($book);
    }

    // Retrieve all books
    public function getBooks()
    {
        $books = Book::all();
        return response()->json($books);
    }

    // Get a book by name
    public function getBookByName($name)
    {
        $book = Book::where('name', $name)->first();
        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }
        return response()->json($book);
    }

    // Delete a book by name
    public function deleteBookByName($name)
    {
        $book = Book::where('name', $name)->first();
        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }
        $book->delete();
        return response()->json(['message' => 'Book deleted successfully']);
    }
}
