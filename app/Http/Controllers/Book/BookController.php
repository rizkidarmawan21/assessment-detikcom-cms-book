<?php

namespace App\Http\Controllers\Book;

use App\Actions\Options\GetBookCategory;
use App\Http\Controllers\AdminBaseController;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BookController extends AdminBaseController
{
    public function __construct(
        GetBookCategory $getBookCategory
    )
    {
        $this->getBookCategory = $getBookCategory;
    }

    public function BookIndex()
    {
        return Inertia::render($this->source . 'books/index', [
            "title" => 'Bookstore | Book Management',
            "additional" => [
                'book_category_list' => $this->getBookCategory->handle()
            ]
        ]);
    }
}
