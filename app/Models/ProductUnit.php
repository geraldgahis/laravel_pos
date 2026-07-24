<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductUnit extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'conversion_qty' => 'decimal:3',
            'is_default' => 'boolean'
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}