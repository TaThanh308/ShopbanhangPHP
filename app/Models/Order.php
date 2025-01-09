<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'customer_name',
        'customer_address',
        'customer_phone',
        'payment_method',
        'total_price',
        'status',
    ];
    

    public function items()
{
    return $this->hasMany(OrderItem::class);
}
public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

}
