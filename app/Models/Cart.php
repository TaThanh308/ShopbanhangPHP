<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'carts';
    protected $fillable = ['user_id'];

    // Quan hệ tới CartItem
    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    // Quan hệ tới sản phẩm thông qua CartItem
    public function products()
    {
        return $this->hasManyThrough(Product::class, CartItem::class, 'cart_id', 'id', 'id', 'product_id');
    }

    
}
