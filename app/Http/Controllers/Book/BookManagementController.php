<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\AdminBaseController;
use App\Http\Resources\Books\BookListResource;
use App\Services\Books\BookManagementService;
use Exception;
use Illuminate\Http\Request;

class BookManagementController extends AdminBaseController
{
    public function __construct(BookManagementService $bookManagementService)
    {
        $this->bookManagementService = $bookManagementService;
    }

    public function getData(Request $request)
    {
        try {
            $data = $this->bookManagementService->getData($request);

            $result = new BookListResource($data);
            return $this->respond($result);
        } catch (Exception $e) {
            return $this->exceptionError($e->getMessage());
        }
    }
}
