<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
    ];

    /**
     * The attributes that should be appended to this model.
     */
    protected $appends = [
        'is_in_cart',
        'total_price',
    ];

    /**
     * Get the cart records associated with the product.
     */
    public function carts()
    {
        return $this->belongsToMany(Cart::class)->withPivot('quantity')->withTimestamps();
    }

    /**
     * Scope a query to only include products that are in the cart.
     */
    public function scopeInCart($query)
    {
        return $query->whereHas('carts', function ($query) {
            $query->where('user_id', auth()->id())
                ->where('checked_out', false);
        });
    }

    /**
     * Get the is_in_cart attribute.
     */
    public function getIsInCartAttribute(): bool
    {
        return $this->carts()
            ->where('user_id', auth()->id())
            ->where('checked_out', false)
            ->exists();
    }

    /**
     * Get the total_price attribute.
     */
    public function getTotalPriceAttribute()
    {
        $userId = auth()->id();
        $cart = $this->carts()
            ->where('user_id', $userId)
            ->where('checked_out', false)
            ->first();

        if (!$cart) {
            return null;
        }

        return $this->price * $cart->pivot->quantity;
    }
}
