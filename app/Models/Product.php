<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\OrderItem;
class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',        // Tên sản phẩm
        'description', // Mô tả sản phẩm
        'quantity',    // Số lượng
        'price',       // Giá sản phẩm
        'img',
        'category_id', // Danh mục liên quan
    ];
    public function category() {
        return $this->belongsTo(Category::class);
    }
    
}
