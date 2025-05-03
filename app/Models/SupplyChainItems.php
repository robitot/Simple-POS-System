<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplyChainItems extends Model
{
    use HasFactory;

    protected $fillable = [
        'supply_chain_id',
        'inventory_id',
        'qty',
        'uom',
    ];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
}
