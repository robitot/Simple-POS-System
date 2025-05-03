<?php

namespace App\Livewire\Inventory;

use App\Livewire\Forms\Pagination;
use App\Models\Inventory as ModelsInventory;
use Livewire\Component;
use Livewire\WithPagination;

class Inventory extends Component
{

    use WithPagination;

    //make form for this para useable
    public $search;
    public $paginate = 5;
    public $sor = 'desc';
    public Pagination $pagination;

    public function render()
    {
        $inventories = $this->getInventories();
        return view('livewire.inventory.inventory', [
            'inventories' => $inventories,
        ]);
    }

    private function getInventories()
    {
        $inventories = ModelsInventory::where('name', 'like', "%{$this->pagination->search}%")
            ->orderBy('created_at', 'desc')
            ->paginate($this->pagination->paginate);

        return $inventories;
    }

    
}
