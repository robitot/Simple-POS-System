<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'name',
        'quantity',
        'current_price',
        'description',
        'store_id',
        'is_active',
        'category_id',
    ];

    public function sizes()
    {
        return $this->hasMany(ProductSize::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
}
