<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\AdminBaseController;
use App\Http\Requests\Books\CreateBookRequest;
use App\Http\Resources\Books\BookListResource;
use App\Http\Resources\Books\SubmitBookResource;
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

    public function createData(CreateBookRequest $request)
    {
        try {
            $data = $this->bookManagementService->createData($request);

            $result = new SubmitBookResource($data, 'Book created successfully');
            return $this->respond($result);
        } catch (Exception $e) {
            return $this->exceptionError($e->getMessage());
        }
    }

    public function deleteData($id)
    {
        try {
            $data = $this->bookManagementService->deleteData($id);

            $result = new SubmitBookResource($data, 'Book deleted successfully');
            return $this->respond($result);
        } catch (Exception $e) {
            return $this->exceptionError($e->getMessage());
        }
    }
}
