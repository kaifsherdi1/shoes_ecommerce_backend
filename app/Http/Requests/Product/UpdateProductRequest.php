<?php
namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest {
    public function authorize() { return $this->user()->can('update', $this->route('id') ? \App\Models\Product::find($this->route('id')) : \App\Models\Product::class); }
    public function rules() {
        return [
            'name'=>'sometimes|required|string|max:255',
            'description'=>'nullable|string',
            'price'=>'sometimes|required|numeric|min:0',
            'category_id'=>'nullable|exists:categories,id',
            'brand_id'=>'nullable|exists:brands,id',
            'active'=>'boolean'
        ];
    }
}
