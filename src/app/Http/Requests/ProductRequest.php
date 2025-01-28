<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @param Request $request
     * @return array
     */
    public function rules(Request $request): array
    {
        $id = $this->route('id');

        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_img_url' => 'required|url',
            'sku' => [
                'required',
                'string',
                'max:100',
                Rule::unique('products', 'sku')->ignore($id, 'product_id'),
            ],
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'is_active' => 'required|boolean',
            'category_id' => 'required|exists:categories,category_id',
            'personsupplier_id' => 'required|exists:person_supplier,personsupplier_id',
        ];
    }

}
