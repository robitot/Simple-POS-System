<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class POSOrderItems extends Model
{
    use HasFactory;
    protected $table ="pos_order_items";
    protected $guarded = [];

    public function order()
    {
        return $this->belongsTo(POSOrders::class);
    }
}
