<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource {
    public function toArray($request) {
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'slug'=>$this->slug,
            'description'=>$this->description,
            'price'=>$this->price,
            'category'=>$this->whenLoaded('category'),
            'brand'=>$this->whenLoaded('brand'),
            'images'=>$this->images->map(fn($i)=>[
                'id'=>$i->id,
                'path'=>asset('storage/'.$i->path),
                'is_primary'=>$i->is_primary
            ]),
            'variants'=>$this->whenLoaded('variants'),
            'avg_rating'=>$this->reviews()->avg('rating')
        ];
    }
}
