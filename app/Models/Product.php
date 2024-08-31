<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cart;
use App\Modles\Transaction;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'description',
        'image',
        'stock'
    ];

    public function cart(){
        return $this->hasMany(Cart::class);
    }

    public function transaction(){
        return $this->hasMany(Transaction::class);
    }
}
