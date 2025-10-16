<?php
namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest {
    public function authorize() { return $this->user()->can('create', \App\Models\Product::class); }

    public function rules() {
        return [
            'name'=>'required|string|max:255',
            'description'=>'nullable|string',
            'price'=>'required|numeric|min:0',
            'category_id'=>'nullable|exists:categories,id',
            'brand_id'=>'nullable|exists:brands,id',
            'active'=>'boolean'
        ];
    }
}
