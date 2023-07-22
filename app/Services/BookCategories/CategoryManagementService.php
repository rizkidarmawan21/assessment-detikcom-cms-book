<?php 

namespace App\Services\BookCategories;

use App\Models\BookCategory;

class CategoryManagementService
{
    public function getData($request)
    {
        $search = $request->search;

        $query = BookCategory::query();

        $query->when(request('search', false), function ($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%');
        });

        return $query->paginate(10);
    }   

    public function createData($request)
    {
        $data = $request->only(['name']);

        BookCategory::create($data);

        return $data;
    }

    public function updateData($request, $id)
    {
        $data = $request->only(['name']);

        $category = BookCategory::findOrFail($id);

        $category->update($data);

        return $data;
    }

    public function deleteData($id)
    {
        $category = BookCategory::findOrFail($id);

        $category->delete();

        return $category;
    }

}