<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplyChain extends Model
{
    use HasFactory;

    protected $fillable = [
        'in_charge',
        'receipt',
        'amount',
        'status',
    ];

    public function supplyChainItems()
    {
        return $this->hasMany(SupplyChainItems::class);
    }
}
