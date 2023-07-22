<?php

use App\Http\Controllers\BookCategory\BookCategoryController;
use App\Http\Controllers\BookCategory\BookCategoryManagementController;

Route::prefix('categories')->name('categories.')->group(function () {
    Route::controller(BookCategoryController::class)->middleware('can:view_book_category_management')->group(function () {
        Route::get('/', 'BookCategoryIndex')->name('index');

        Route::controller(BookCategoryManagementController::class)->group(function () {
            Route::get('get-data', 'getData')->name('get-data');
            Route::post('create-data', 'createData')->name('create-data');
            Route::post('{id}/update-data', 'updateData')->name('update-data');
            Route::delete('{id}/delete', 'deleteData')->name('delete');
        });
    });
});
