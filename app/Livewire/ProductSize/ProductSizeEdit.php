<?php

namespace App\Livewire\ProductSize;

use App\Livewire\Forms\CreateDrinkSizeForm;
use App\Models\Inventory;
use App\Models\ProductSize;
use Livewire\Component;

class ProductSizeEdit extends Component
{

    public CreateDrinkSizeForm $drinkSize;
    public CreateDrinkSizeForm $newDrink;
    public $productName;
    public $id;
    public $addedInvetories = [];
    public $size;
    public $inventoryId;
    public $isAddNew;
    public $inventories;
    public $addedNewInventories;

    public function mount($sizeId)
    {
        $this->size = ProductSize::with('product')->find($sizeId);
        $this->id = $this->size->id;
        
        if ($this->size == null || $this->size->product == null) {
            return redirect()->route('productSize'); 
        }
        
        foreach ($this->size->inventories as $inventory) {
            $this->addedInvetories[] = [
                'id' => $inventory->id, 
                'name' => $inventory->name, 
                'quantity' => $inventory->pivot->quantity,
                'uom' => $inventory->pivot->uom,
                'is_editing' => false,
            ];
        }

        $this->productName = $this->size->product->name;

        $this->drinkSize->name = $this->size->name;

        $this->drinkSize->price = $this->size->current_price;
    }

    public function edit()
    {
        $this->size->name = $this->drinkSize->name; 

        $this->size->current_price = $this->drinkSize->price;

        if ($this->size->isDirty()) {
            $this->size->save(); 
        }

        $this->dispatch('edited-successfully');
    }

    public function editQuantity($index)
    {
        $this->addedInvetories[$index]['is_editing'] = true;

    }

    public function cancelEdit($index)
    {
        $this->addedInvetories[$index]['is_editing'] = false;
    }

    public function saveQuantity($index)
    {
         $inventory = Inventory::find($this->addedInvetories[$index]['id']);
        
         $inventory->productSize()->updateExistingPivot($this->size->id, [
             'quantity' => $this->addedInvetories[$index]['quantity'],
         ]);
 
         // After saving, switch out of editing mode
         $this->addedInvetories[$index]['is_editing'] = false;
    }

    public function remove($id)
    {
        $this->size->inventories()->detach($id);
        
        $this->addedInvetories = collect($this->addedInvetories)->filter(function ($item) use ($id) {
            return $item['id'] !== $id; 
        })->values()->toArray();
        $this->dispatch('removed-successfully');
    }

    private function getInventories()
    {
        return $this->inventories = Inventory::orderBy('created_at', 'desc')->get();
    }

    public function addInventory()
    {
        if (
            empty($this->newDrink->qty) ||
            empty($this->newDrink->uom) ||
            empty($this->inventoryId)
        ) {
            $this->dispatch('failed-to-add');
            return;
        }


        if (is_array($this->inventories)) {
            $inventory = collect($this->inventories)->firstWhere('id', $this->inventoryId);
        } else {
            $inventory = $this->inventories->find($this->inventoryId);
        }

        if ($inventory) {
            $exists = collect($this->addedInvetories)->firstWhere('id', $inventory->id);

            if (!$exists) {
                $this->addedInvetories[] = [
                    'id' => $inventory->id,
                    'name' => $inventory->name,
                    'quantity' => $this->newDrink->qty,
                    'uom' => $this->newDrink->uom,
                    'is_editing' => false,
                ];

                $this->saveInventoryToDatabase($inventory);

                $this->dispatch('added-successfully');
            }
            else
            {
                
            }
        }

      
    }

    protected function saveInventoryToDatabase($inventory)
    {
        $this->size->inventories()->attach($inventory['id'], [
            'quantity' => $this->newDrink->qty,
            'uom' => $this->newDrink->uom,
        ]);
    }

    public function render()
    {
        return view('livewire.product-size.product-size-edit',[
            'inventories' => $this->getInventories()
        ]);
    }
}
