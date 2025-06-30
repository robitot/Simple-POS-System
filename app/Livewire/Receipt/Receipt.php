<?php

namespace App\Livewire\Receipt;

use App\Models\POSOrders;
use Livewire\Component;
use Livewire\WithPagination;
use App\Livewire\Forms\Pagination;

class Receipt extends Component
{
    use WithPagination;

    public Pagination $pagination;

    public function render()
    {
        return view('livewire.receipt.receipt', [
            'orders' => $this->getOrders()
        ]);
    }
    public function getOrders()
    {
        $query = POSOrders::query();

        if (!empty($this->pagination->search)) {
            $query->where(function ($q) {
                $q->where('id', $this->pagination->search)
                    ->orWhere('reference_number', 'like', "%{$this->pagination->search}%");
            });
        }

        return $query->orderBy('created_at', 'desc')
            ->paginate($this->pagination->paginate);
    }
}
