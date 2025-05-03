<?php

namespace App\Livewire\SupplyChain;

use App\Models\Inventory;
use App\Models\SupplyChain;
use App\Models\SupplyChainItems;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $invId;
    #[Validate('required')]
    public $qty;
    #[Validate('required')]
    public $inCharge;
    #[Validate('required')]
    public $amount;
    public $addedInventories = [];
    #[Validate('required')]
    public $image;
    public $inventories;
    public $uom;

    public function render()
    {
        return view('livewire.supply-chain.create', [
            'inventories' => $this->inventories = Inventory::all()
        ]);
    }

    public function create()
    {
        $this->validate();

        $isAdmin = auth()->user()->user_role == 'admin';

        $imagePath = null;
        if ($this->image) {
            $imagePath = $this->image->store('products', 'public');
        }

        DB::beginTransaction();
        try {
            $supplyChain = SupplyChain::create([
                'in_charge' => $this->inCharge,
                'receipt' => $imagePath,
                'amount' => $this->amount,
                'status' => $isAdmin ? 'approved' : 'pending',
            ]);

            foreach ($this->addedInventories as $inventory) {
                SupplyChainItems::create([
                    'supply_chain_id' => $supplyChain->id,
                    'inventory_id' => $inventory['id'],
                    'qty' => $inventory['quantity'],
                    'uom' => $inventory['uom'],
                ]);

                if ($isAdmin) {
                    $db_inventory = $this->inventories->find($inventory['id']);
                    if ($db_inventory) {
                        $db_inventory->quantity += $inventory['quantity'];
                        $db_inventory->save();
                    }
                }
            }

            $this->dispatch('success');
            DB::commit();
            redirect()->route('supplyChain');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('error');
        }
    }

    public function add()
    {
        if (
            empty($this->qty) ||
            empty($this->uom) ||
            empty($this->invId)
        ) {
            $this->dispatch('failed-to-add');
            return;
        }

        if (is_array($this->inventories)) {
            $inventory = collect($this->inventories)->firstWhere('id', $this->invId);
        } else {
            $inventory = $this->inventories->find($this->invId);
        }

        $exists = collect($this->addedInventories)->firstWhere('id', $inventory->id);

        if (!$exists) {
            $this->addedInventories[] = [
                'id' => $inventory->id,
                'name' => $inventory->name,
                'quantity' => $this->qty,
                'uom' => $this->uom,
            ];
        }
    }

    public function remove($id)
    {
        $this->addedInventories = array_filter($this->addedInventories, function ($inventory) use ($id) {
            return $inventory['id'] !== $id;
        });

        $this->addedInventories = array_values($this->addedInventories);

        $this->dispatch('removed-successfully');
    }
}
