<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\ProductImage;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate(['file'=>'required|image|max:5120']);
        $path = $request->file('file')->store('products', 'public');

        // optional: return full URL
        return response()->json(['path'=>Storage::url($path),'raw'=>$path]);
    }
}
