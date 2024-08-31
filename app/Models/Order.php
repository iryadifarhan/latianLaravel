<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Transaction;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'is_paid',
        'user_id',
        'payment_receipt'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function transaction(){
        return $this->hasMany(Transaction::class);
    }
}
