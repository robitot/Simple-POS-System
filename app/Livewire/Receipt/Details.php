<?php

namespace App\Livewire\Receipt;

use App\Models\POSOrderItems;
use Livewire\Component;

class Details extends Component
{

    public $products;

    public function render()
    {
        return view('livewire.receipt.details', ['orders' => $this->products ]);
    }

    public function mount($id)
    {
        $this->products = POSOrderItems::where('pos_order_id', $id)->get();
    }
}
