<?php

namespace App\Http\Controllers\BookCategory;

use App\Http\Controllers\AdminBaseController;
use Inertia\Inertia;

class BookCategoryController extends AdminBaseController
{
    public function bookCategoryIndex()
    {
        return Inertia::render($this->source . 'bookCategories/index', [
            "title" => 'Bookstore | Book Category Management',
        ]);
    }
}
