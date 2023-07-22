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
    }

    public function updateData($request, $id)
    {
    }

    public function deleteData($id)
    {
    }
}
