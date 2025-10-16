<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id'=>'required|int|exists:products,id',
            'rating'=>'required|int|min:1|max:5',
            'comment'=>'nullable|string'
        ]);
        $data['user_id'] = $request->user()->id;
        $review = Review::create($data);
        return response()->json($review, 201);
    }
}
