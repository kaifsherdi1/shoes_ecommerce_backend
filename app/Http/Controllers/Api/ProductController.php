<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $q = Product::with(['primaryImage','variants','category','brand']);
        if ($request->filled('category')) $q->where('category_id', $request->category);
        if ($request->filled('q')) $q->where('name','like','%'.$request->q.'%');
        $products = $q->paginate(20);
        return ProductResource::collection($products);
    }

    public function show($id)
    {
        $product = Product::with(['images','variants','reviews'])->findOrFail($id);
        return new ProductResource($product);
    }

    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['name']).'-'.uniqid();
        $product = Product::create($data);
        return new ProductResource($product);
    }

    public function update(UpdateProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->update($request->validated());
        return new ProductResource($product);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json(null, 204);
    }
}
