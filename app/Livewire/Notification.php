<?php

namespace App\Livewire;

use App\Models\Expense;
use App\Models\SupplyChain;
use Livewire\Component;

class Notification extends Component
{
    public $expensePending = 0;
    public $supplyPending = 0;

    public function render()
    {
        $this->getExpensePending();
        $this->getSupplyPending();
        return view('livewire.notification');
    }

    private function getExpensePending()
    {
        $this->expensePending = Expense::where('status', 'pending')->count();
    }

    private function getSupplyPending()
    {
        $this->supplyPending = SupplyChain::where('status', 'pending')->count();
    }
}
