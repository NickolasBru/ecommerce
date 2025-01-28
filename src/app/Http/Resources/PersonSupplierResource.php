<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PersonSupplierResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'person_id' => $this->person_id,
            'company_name' => $this->company_name,
            'vat_number' => $this->vat_number,
            'products_count' => $this->products_count
        ];
    }
}
