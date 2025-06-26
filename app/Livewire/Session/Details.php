<?php

namespace App\Livewire\Session;

use App\Models\POSOrderItems;
use Livewire\Component;
use Livewire\WithPagination;
use App\Livewire\Forms\Pagination;

class Details extends Component
{
    use WithPagination;

    public Pagination $pagination;
    public $orderId;

    public function mount($id)
    {
        $this->orderId = $id;
    }

    public function render()
    {
        $orders = POSOrderItems::where('pos_order_id', $this->orderId)
            ->where(function ($query) {
                $query->where('product_name', 'like', "%{$this->pagination->search}%")
                    ->orWhere('id', $this->pagination->search);
            })
            ->orderByRaw('CAST(qty AS UNSIGNED) DESC')
            ->paginate($this->pagination->paginate);

        return view('livewire.session.details', [
            'orders' => $orders
        ]);
    }
}
