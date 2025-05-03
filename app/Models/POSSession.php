<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class POSSession extends Model
{
    use HasFactory;
    protected $table = 'pos_sessions'; 

    protected $guarded = [];

    public function orders()
    {
        return $this->hasMany(POSOrders::class, 'pos_session_id'); 
    }
    
}
