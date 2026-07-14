<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;


class Product extends Model
{
    use HasFactory, SoftDeletes;
 
    protected $fillable = [
        'barcode',
        'name',
        'description',
        'selling_price',
        'cost_price',
        'quantity',
        'unit',
        'image',
    ];
 
    protected $casts = [
        'selling_price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'quantity' => 'decimal:2',
    ];
 
    /**
     * Full public URL for the product's image, or null if it doesn't have
     * one. Views should check for null and render a placeholder — no
     * physical "default.png" file is required on disk for this to work.
     */
    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) {
            return null;
        }
 
        /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
        $disk = Storage::disk('public');
 
        return $disk->url($this->image);
    }

    public function transactionItems(): HasMany
    {
        return $this->hasMany(TransactionItem::class);
    }
}
