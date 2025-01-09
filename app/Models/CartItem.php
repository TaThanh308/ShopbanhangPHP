<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $table = 'cart_items';
    protected $fillable = ['cart_id', 'product_id', 'quantity'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
