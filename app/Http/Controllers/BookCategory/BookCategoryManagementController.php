<?php

namespace App\Http\Controllers\BookCategory;

use App\Http\Controllers\AdminBaseController;
use App\Http\Requests\BookCategory\BookCategoryRequest;
use App\Http\Resources\BookCategory\CategoryListResource;
use App\Http\Resources\BookCategory\SubmitCategoryResource;
use App\Services\BookCategories\CategoryManagementService;
use Exception;
use Illuminate\Http\Request;

class BookCategoryManagementController extends AdminBaseController
{
    public function __construct(CategoryManagementService $categoryManagementService) 
    {
        $this->categoryManagementService = $categoryManagementService;
    }

    public function getData(Request $request)
    {
        try {
            $data = $this->categoryManagementService->getData($request);

            $result = new CategoryListResource($data);
            return $this->respond($result);
        } catch (Exception $e) {
            return $this->exceptionError($e->getMessage());
        }
    }

    public function createData(BookCategoryRequest $request)
    {
        try {
            $data = $this->categoryManagementService->createData($request);

            $result = new SubmitCategoryResource($data, 'Book Category created successfully');

            return $this->respond($result);
        } catch (Exception $e) {
            return $this->exceptionError($e->getMessage());
        }
    }

    public function updateData(BookCategoryRequest $request, $id)
    {
        try {
            $data = $this->categoryManagementService->updateData($request, $id);

            $result = new SubmitCategoryResource($data, 'Book Category updated successfully');

            return $this->respond($result);
        } catch (Exception $e) {
            return $this->exceptionError($e->getMessage());
        }
    }

    public function deleteData($id)
    {
        try {
            $data = $this->categoryManagementService->deleteData($id);

            $result = new SubmitCategoryResource($data, 'Book Category deleted successfully');

            return $this->respond($result);
        } catch (Exception $e) {
            return $this->exceptionError($e->getMessage());
        }
    }
}
