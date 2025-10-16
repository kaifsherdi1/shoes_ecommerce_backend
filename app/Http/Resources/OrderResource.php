<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource {
    public function toArray($request) {
        return [
            'id'=>$this->id,
            'status'=>$this->status,
            'subtotal'=>$this->subtotal,
            'shipping'=>$this->shipping,
            'total'=>$this->total,
            'items'=>$this->items,
            'shipping_address'=>$this->shipping_address,
            'payment_meta'=>$this->payment_meta,
            'created_at'=>$this->created_at
        ];
    }
}
