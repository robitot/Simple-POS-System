<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class POSOrders extends Model
{
    use HasFactory;

    protected $table = "pos_orders";
    protected $guarded = [];

    public function session()
    {
        return $this->belongsTo(POSSession::class, 'pos_session_id'); 
    }


    public function orderItems()
    {
        return $this->hasMany(POSOrderItems::class);
    }
}
