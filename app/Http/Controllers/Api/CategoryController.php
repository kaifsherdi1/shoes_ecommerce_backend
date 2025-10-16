<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index() {
        return response()->json(Category::with('children')->get());
    }

    public function show($id) {
        return response()->json(Category::with('products')->findOrFail($id));
    }
}
