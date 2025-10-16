<?php
namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    public function storeProductImage(UploadedFile $file) {
        $path = $file->store('products', 'public');
        return $path;
    }
}
