<?php

namespace App\Http\Resources\Books;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BookListResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->transformCollection($this->collection),
            'meta' => [
                "success" => true,
                "message" => "Success get book lists",
                'pagination' => $this->metaData()
            ]
        ];
    }

    private function transformData($data)
    {
        return [
            'id' => $data->id,
            'title' => $data->title,
            'category_id' => $data->category_id,
            'description' => $data->description,
            'number_of_pages' => $data->number_of_pages,
            'category' => $data->category,
            'author' => $data->author->name,
            'cover_file' => $data->cover,
            'pdf_file' => $data->file,
            'path' => env('APP_URL') . '/storage/'
        ];
    }

    private function transformCollection($collection)
    {
        return $collection->transform(function ($data) {
            return $this->transformData($data);
        });
    }

    private function metaData()
    {
        return [
            "total" => $this->total(),
            "count" => $this->count(),
            "per_page" => (int)$this->perPage(),
            "current_page" => $this->currentPage(),
            "total_pages" => $this->lastPage(),
            "links" => [
                "next" => $this->nextPageUrl()
            ],
        ];
    }
}
