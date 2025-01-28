<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'product_id' => $this->product_id,
            'name' => $this->name,
            'description' => $this->description,
            'coverImageUrl' => $this->cover_img_url,
            'sku' => $this->sku,
            'price' => $this->price,
            'stockQuantity' => $this->stock_quantity,
            'isActive' => $this->is_active,
            'categoryId' => $this->category_id,
            'productSupplier' => ProductSupplierResource::collection($this->whenLoaded('productSupplier')),
        ];
    }
}
