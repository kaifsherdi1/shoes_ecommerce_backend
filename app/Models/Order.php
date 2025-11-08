<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model {
    use HasFactory;

    protected $fillable = ['user_id','status','subtotal','shipping','total','shipping_address','payment_meta'];

    protected $casts = [
        'shipping_address' => 'array',
        'payment_meta' => 'array',
    ];

    public function items() {
        return $this->hasMany(OrderItem::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function payment() {
        return $this->hasOne(Payment::class);
    }
    public function statuses()
{
    return $this->hasMany(OrderStatus::class);
}
}
