<?php

namespace App\Services\Books;

use App\Models\Book;

class BookManagementService
{
    public function getData($request)
    {
        $search = $request->search;

        $query = Book::query();

        $query->when(request('search', false), function ($q) use ($search) {
            $q->where('title', 'like', '%' . $search . '%');
        });

        return $query->paginate(10);
    }

    public function getDetail($id)
    {
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
    }

    public function deleteData($id)
    {
    }
}
