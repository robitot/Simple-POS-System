<?php

namespace App\Livewire\Expense;

use App\Models\Expense;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreateExpense extends Component
{

    #[Validate('required')]
    public $amount = 0;
    #[Validate('required')]
    public $category;
    #[Validate('required')]
    public $inCharge;
    #[Validate('required')]
    public $description;

    public function render()
    {
        return view('livewire.expense.create-expense');
    }

    public function create()
    {
        try {
            $this->validate();

            $isAdmin = auth()->user()->user_role == 'admin';

            Expense::create([
                'amount' => $this->amount,
                'description' => $this->description,
                'in_charge' => $this->inCharge,
                'category' => $this->category,
                'status' => $isAdmin ? 'approved' : 'pending',
            ]);
            $this->dispatch('success');
            return redirect()->route('expense');
        } catch (\Throwable $th) {
            $this->dispatch('error');
        }
    }
}
