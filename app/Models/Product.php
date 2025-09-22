<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductImage;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price'];

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true)
            ->withDefault(function () {
                // Return first image if no primary image
                return $this->images->first() ?: new ProductImage([
                    'path' => 'images/no-image-available.jpg'
                ]);
            });
    }
    public function isUkuranBased()
    {
        return in_array($this->name, ['Spanduk / Baliho', 'Umbul-Umbul', 'Stiker (Branding)']);
    }
}
