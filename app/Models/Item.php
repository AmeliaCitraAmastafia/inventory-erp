<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku',
        'name',
        'category',
        'unit',
        'minimum_stock',
        'current_stock',
        'image_url',
    ];

    protected $casts = [
        'minimum_stock' => 'integer',
        'current_stock' => 'integer',
    ];

    public function movements(): HasMany
    {
        return $this->hasMany(StockMovement::class);
    }
}
