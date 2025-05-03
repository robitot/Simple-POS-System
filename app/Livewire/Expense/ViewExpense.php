<?php

namespace App\Livewire\Expense;

use App\Models\Expense;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ViewExpense extends Component
{

    #[Validate('required')]
    public $amount = 0;
    #[Validate('required')]
    public $category;
    #[Validate('required')]
    public $inCharge;
    #[Validate('required')]
    public $description;
    public $status;
    public $id;


    public function render()
    {
        return view('livewire.expense.view-expense');
    }

    public function mount($expenseId)
    {
        $this->id = $expenseId;
        $expense = Expense::find($expenseId);

        if($expense == null) return redirect()->route('expense');

        $this->amount = $expense->amount;
        $this->category = $expense->category;
        $this->inCharge = $expense->in_charge;
        $this->description = $expense->description;
        $this->status = $expense->status;
    }

    public function approve($id)
    {
        $expense = Expense::find($id);

        if ($expense) {
            $expense->status = 'approved';
            $expense->save();
            $this->dispatch('success');
            return;
        }

        $this->dispatch('error');
    }

    public function reject($id)
    {
        $expense = Expense::find($id);

        if ($expense) {
            $expense->status = 'rejected';
            $expense->save();
            $this->dispatch('success');
            return;
        }

        $this->dispatch('error');
    }
}
