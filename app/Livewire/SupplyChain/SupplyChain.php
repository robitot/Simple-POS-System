<?php

namespace App\Livewire\SupplyChain;

use App\Livewire\Forms\Pagination;
use App\Models\Inventory;
use App\Models\SupplyChain as ModelsSupplyChain;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithoutUrlPagination;

class SupplyChain extends Component
{
    use WithoutUrlPagination;
    public Pagination $pagination;
    
    public function getSupplies()
    {
        $supplies = ModelsSupplyChain::where('in_charge', 'like', "%{$this->pagination->search}%")
        ->orderBy('created_at', 'desc')
        ->paginate($this->pagination->paginate);

        return $supplies;
    }

    public function render()
    {
        return view('livewire.supply-chain.supply-chain',[
            'supplies' => $this->getSupplies()
        ]);
    }

    public function approved($id)
    {
        $supply = ModelsSupplyChain::with('supplyChainItems')->find($id);
        $supply->status = 'approved';
        $supply->save();

        $inventories = Inventory::all();
        foreach($supply->supplyChainItems as $item)
        {
            $db_inventory = $inventories->find($item->inventory_id);

            if ($db_inventory) {
                $db_inventory->quantity += $item->qty;
                $db_inventory->save();
            }
        }
    }

    public function rejected($id)
    {
        $supply = ModelsSupplyChain::with('supplyChainItems')->find($id);
        $supply->status = 'rejected';
        $supply->save();
    }
}
