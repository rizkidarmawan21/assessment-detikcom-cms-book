<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\AdminBaseController;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BookController extends AdminBaseController
{
    public function BookIndex()
    {
        return Inertia::render($this->source . 'books/index', [
            "title" => 'Bookstore | Book Management',
        ]);
    }
}
