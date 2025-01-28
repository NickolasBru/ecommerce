<?php

namespace App\Http\Resources;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * Class PaginatedResourceCollection
 *
 * @package App\Http\Resources
 */
class PaginatedResourceCollection extends ResourceCollection
{
    /**
     * @var array
     */
    protected array $pagination;

    /**
     * Sets paginated response values.
     *
     * @param mixed $resource
     *
     * @return void
     */
    public function __construct($resource)
    {
        if ($resource instanceof LengthAwarePaginator) {
            $this->pagination = [
                'total'       => $resource->total(),
                'count'       => $resource->count(),
                'perPage'     => $resource->perPage(),
                'currentPage' => $resource->currentPage(),
                'totalPages'  => $resource->lastPage(),
            ];

            $resource = $resource->getCollection();
        } else {
            $this->pagination = [];
        }

        parent::__construct($resource);
    }

    /**
     * Sets the shape of the paginated response.
     *
     * @param $request
     *
     * @return array Response data.
     */
    public function toArray($request): array
    {
        return [
            'metadata' => $this->pagination,
            'data'     => $this->collection,
        ];
    }
}
