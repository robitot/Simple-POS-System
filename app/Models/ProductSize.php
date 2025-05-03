<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSize extends Model
{
    use HasFactory;

    protected $fillable = ['name','current_price','previous_price'];

     //many inventory or ingridients
    public function inventories()
    {
        return $this->belongsToMany(Inventory::class,'product_size_inventories')
                    ->withPivot('quantity','uom')
                    ->withTimestamps();
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function productSizeItems()
    {
        return $this->hasMany(ProductSizeItem::class);
    }
    
}
