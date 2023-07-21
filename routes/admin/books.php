<?php

use App\Http\Controllers\Book\BookController;

Route::prefix('books')->name('books.')->group(function () {
    Route::controller(BookController::class)->middleware('can:view_book_management')->group(function () {
        Route::get('/', 'BookIndex')->name('index');
    });
});
