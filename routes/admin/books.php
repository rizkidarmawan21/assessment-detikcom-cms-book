<?php

use App\Http\Controllers\Book\BookController;
use App\Http\Controllers\Book\BookManagementController;

Route::prefix('books')->name('books.')->group(function () {
    Route::controller(BookController::class)->middleware('can:view_book_management')->group(function () {
        Route::get('/', 'BookIndex')->name('index');

        Route::controller(BookManagementController::class)->group(function () {
            Route::get('get-data', 'getData')->name('get-data');
            Route::post('create-data', 'createData')->name('create-data');
            Route::post('{id}/update-data', 'updateData')->name('update-data');
            Route::delete('{id}/delete', 'deleteData')->name('delete');
            Route::get('download/pdf', 'exportPDF')->name('export-pdf');
        });
    });
});
