<?php

namespace App\Livewire\Expense;

use App\Livewire\Forms\Pagination;
use App\Models\Expense as ModelsExpense;
use Livewire\Component;
use Livewire\WithoutUrlPagination;

class Expense extends Component
{

    use WithoutUrlPagination;
    public Pagination $pagination;

    public function render()
    {
        return view('livewire.expense.expense', ['expenses' => $this->getExpenses()]);
    }

    public function getExpenses()
    {
        $expenses = ModelsExpense::where('in_charge', 'like', "%{$this->pagination->search}%")
            ->orderBy('created_at', 'desc')
            ->paginate($this->pagination->paginate);

        return $expenses;
    }

    public function approve($id)
    {
        $expense = ModelsExpense::find($id);

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
        $expense = ModelsExpense::find($id);

        if ($expense) {
            $expense->status = 'rejected';
            $expense->save();
            $this->dispatch('success');
            return;
        }

        $this->dispatch('error');
    }
}
