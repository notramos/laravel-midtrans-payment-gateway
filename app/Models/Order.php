<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    
    protected $fillable = ['order_number', 'user_id', 'total_amount', 'status', 'snap_token','shipping_address', 'phone_number','is_read','last_notified_at','last_viewed_at'];
    protected $casts = [
    'is_read' => 'boolean',
];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function scopeNewNotifications($query)
    {
        return $query->where(function($q) {
            $q->whereNull('last_viewed_at')
              ->orWhereColumn('last_notified_at', '>', 'last_viewed_at');
        });
    }

    // Method untuk update last_viewed_at
    public function markAsViewed()
    {
        $this->update(['last_viewed_at' => now()]);
        return $this;
    }
}
