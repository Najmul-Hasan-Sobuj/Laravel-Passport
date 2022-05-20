<?php

namespace App\Http\Controllers\API;

use App\Models\Book;
use App\Models\Author;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    public function index()
    {
        $data = Book::get();
        return response()->json([
            'status' => 1,
            'message' => 'all Books Data',
            'data' => $data,
        ]);
    }

    public function authorBook()
    {
        $authorID = auth()->user()->id;
        $data = Author::find($authorID)->books;
        return response()->json([
            'status' => 1,
            'message' => 'Author Books',
            'data' => $data,
        ]);
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'title'       => 'required',
            'book_cost'   => 'required',
        ]);

        if ($validation->passes()) {
            Book::create([
                'auther_id'   => auth()->user()->id,
                'title'       => $request->title,
                'description' => $request->description,
                'book_cost'   => $request->book_cost,
            ]);
            return response()->json([
                'status' => 1,
                'message' => 'Successfully registered'
            ]);
        } else {
            return response()->json([
                'error' => $validation->messages(),
            ]);
        }
    }

    public function edit($id)
    {
        $authorID = auth()->user()->id;

        if (Book::where([
            'author_id' => $authorID,
            'id' => $id
        ])->exists()) {
            $data = Book::find($id);
            return response()->json([
                'status' => true,
                'message' => 'Book data found',
                'data' => $data
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Author Books dose not exists'
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $authorID = auth()->user()->id;

        if (Book::where([
            'author_id' => $authorID,
            'id' => $id
        ])->exists()) {
            // $insertData = [
            //     'title'       => $request->title,
            //     'description' => $request->description,
            //     'book_cost'   => $request->book_cost,
            // ];
            $book = Book::find($id);
            // $data->update($insertData);
            $book->title       = !empty($request->title) ? $request->title : $book->title;
            $book->description = !empty($request->description) ? $request->description : $book->description;
            $book->book_cost   = !empty($request->book_cost) ? $request->book_cost : $book->book_cost;
            $book->save();
            return response()->json([
                'status' => 1,
                'message' => 'Book data has been updated'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Author Books dose not exists'
            ]);
        }
    }

    public function delete($id)
    {
        $authorID = auth()->user()->id;

        if (Book::where([
            'author_id' => $authorID,
            'id' => $id
        ])->exists()) {
            $data = Book::find($id);
            $data->delete();
            return response()->json([
                'status' => true,
                'message' => 'Book data deleted',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Author Books dose not exists'
            ]);
        }
    }
}
