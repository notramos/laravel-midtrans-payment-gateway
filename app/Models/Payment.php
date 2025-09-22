<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;
    
    protected $fillable = ['order_id', 'payment_type', 'transaction_id', 'status', 'amount', 'payment_details'];
    
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
