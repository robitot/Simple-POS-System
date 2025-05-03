<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    // puwede to guarded na lang
    protected $fillable = [
        'image',
        'name',
        'quantity',
        'current_price',
        'previous_price',
        'uom',
        'store_id',
    ];

    // many products
    public function productSize()
    {
        return $this->belongsToMany(ProductSize::class,'product_size_inventories')
                    ->withPivot('quantity','uom')
                    ->withTimestamps();
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function supplyChainItems()
    {
        return $this->hasMany(SupplyChainItems::class);
    }

}
