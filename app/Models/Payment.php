<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model {
    use HasFactory;

    protected $fillable = ['order_id','gateway','status','meta','amount'];

    protected $casts = [
        'meta' => 'array',
    ];

    public function order() {
        return $this->belongsTo(Order::class);
    }
}
