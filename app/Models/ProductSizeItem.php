<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductSizeItem extends Model
{
    use HasFactory;

    protected $table = "product_size_inventories";

    protected $guarded = [];

    public function productSize()
    {
        return $this->belongsTo(ProductSize::class);
    }

    public function inventory()
    {
        return $this->hasOne(Inventory::class);
    }
    
}
