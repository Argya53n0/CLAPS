<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_code',
        'user_id',
        'total_price',
        'shipping_fee',
        'status',
        'cancellation_reason',
        'notes',
        'delivery_address',
        'delivery_lat',
        'delivery_lng',
        'payment_method',
        'payment_status',
        'rating',
        'review',
    ];

    protected function casts(): array
    {
        return [
            'total_price' => 'integer',
            'shipping_fee' => 'integer',
            'delivery_lat' => 'decimal:8',
            'delivery_lng' => 'decimal:8',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Generate a unique order code.
     */
    public static function generateCode(): string
    {
        do {
            $code = 'CLP-' . str_pad(random_int(10000, 99999), 5, '0', STR_PAD_LEFT);
        } while (self::where('order_code', $code)->exists());

        return $code;
    }

    public function getFormattedTotalAttribute(): string
    {
        return 'Rp ' . number_format($this->total_price, 0, ',', '.');
    }

    public function getFormattedShippingAttribute(): string
    {
        return 'Rp ' . number_format($this->shipping_fee, 0, ',', '.');
    }

    public function getFormattedGrandTotalAttribute(): string
    {
        return 'Rp ' . number_format($this->total_price + $this->shipping_fee, 0, ',', '.');
    }
}
