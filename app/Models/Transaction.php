<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Order;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'order_id',
        'amount'
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function order(){
        return $this->belongsTo(Order::class);
    }
}
