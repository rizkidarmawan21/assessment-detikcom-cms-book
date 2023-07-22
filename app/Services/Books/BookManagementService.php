<?php

namespace App\Services\Books;

use App\Models\Book;
use Exception;
use Illuminate\Support\Facades\Storage;

class BookManagementService
{
    public function getData($request)
    {
        $search = $request->search;
        $filter_category = $request->filter_category;

        $query = Book::with(['category','author']);

        // if(auth()->user()->hasRole('user')) {
        //     $query->where('author_id', auth()->id());
        // }

        $query->when(request('search', false), function ($q) use ($search) {
            $q->where('title', 'like', '%' . $search . '%');
        });

        $query->when(auth()->user()->hasRole('user'), function ($q) {
            $q->where('author_id', auth()->id());
        });

        $query->when(request('filter_category', false), function ($q) use ($filter_category) {
            $q->where('category_id', $filter_category);
        });

        // dd($query->get());
        return $query->paginate(10);
    }

    public function getPdfData()
    {
        $query = Book::with(['category','author']);
        $query->when(auth()->user()->hasRole('user'), function ($q) {
            $q->where('author_id', auth()->id());
        });

        return $query->get();
    }

    public function createData($request)
    {
        // get data from request
        $data = $request->only(['title', 'category_id', 'description', 'number_of_pages', 'cover']);

        // store cover
        $data['cover'] = $request->file('cover')->store('book/covers', 'public');

        // if file ready in request store file
        if ($request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('book/files', 'public');
        }

        // author id
        $data['author_id'] = auth()->id();

        // create book
        $book = Book::create($data);

        // return book
        return $book;
    }

    public function updateData($request, $id)
    {
        $book = Book::findOrFail($id);

        $data = $request->only(['title', 'category_id', 'description', 'number_of_pages', 'cover']);
        
        if($book->author_id != auth()->id()) {
            throw new Exception('You are not authorized to update this book');
        }

        if($request->hasFile('cover'))
        {
            // delete old cover
            Storage::delete($book->cover);

            // store new cover
            $data['cover'] = $request->file('cover')->store('book/covers', 'public');
        }

        if($request->hasFile('file'))
        {
            // delete old file
            Storage::delete($book->file);

            // store new file
            $data['file'] = $request->file('file')->store('book/files', 'public');
        }

        // update book
        $book->update($data);

        // return book
        return $book;
    }

    public function deleteData($id)
    {
        // get book
        $book = Book::findOrFail($id);

        if($book->author_id != auth()->id()) {
            throw new Exception('You are not authorized to delete this book');
        }

        if($book->cover)
        {
            // delete cover
            Storage::delete($book->cover);
        }

        if($book->file)
        {
            // delete file
            Storage::delete($book->file);
        }

        // delete book
        $book->delete();

        // return book
        return $book;
    }
}
