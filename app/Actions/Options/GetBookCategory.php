<?php

namespace App\Actions\Options;

use App\Models\BookCategory;

class GetBookCategory
{
    public function handle()
    {
        $category = BookCategory::pluck('name', 'id');

        return $category;
    }
}
