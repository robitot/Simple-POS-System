<?php

namespace App\Livewire\ProductSize;

use App\Livewire\Forms\CreateDrinkSizeForm;
use App\Livewire\Forms\GetInventoriesForm;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\ProductSize;
use Livewire\Component;

class ProductSizeCreate extends Component
{

    public CreateDrinkSizeForm $createDrinkSize;
    public $addedInventories = [];
    public $inventoryId;
    public $inventories;
    public $productId;

    public function addInventory()
    {

        if (
            empty($this->createDrinkSize->qty) ||
            empty($this->createDrinkSize->uom) ||
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
            $exists = collect($this->addedInventories)->firstWhere('id', $inventory->id);

            if (!$exists) {
                $this->addedInventories[] = [
                    'id' => $inventory->id,
                    'name' => $inventory->name,
                    'quantity' => $this->createDrinkSize->qty,
                    'uom' => $this->createDrinkSize->uom,
                ];
            }
        }

        $this->dispatch('added-successfully');
    }

    public function remove($id)
    {
        $this->addedInventories = array_filter($this->addedInventories, function ($inventory) use ($id) {
            return $inventory['id'] !== $id;
        });

        $this->addedInventories = array_values($this->addedInventories);

        $this->dispatch('removed-successfully');
    }


    public function create()
    {
        $this->validate();

        if (empty($this->addedInventories)) {
            $this->dispatch('error');
            return;
        }

        try {

            if ($this->productId == 0) {
                $this->dispatch('error');
                return;
            }

            $productSize = ProductSize::create([
                'name' => $this->createDrinkSize->name,
                'current_price' => $this->createDrinkSize->price,
                'previous_price' => 0,
            ]);

            $product = Product::find($this->productId);
            
            if ($product) {
                $product->sizes()->save($productSize);
            } else {
                $this->dispatch('failed-to-create-size');
                return;
            }

            foreach ($this->addedInventories as $inventory) {
                $productSize->inventories()->attach($inventory['id'], [
                    'quantity' => $inventory['quantity'],
                    'uom' => $inventory['uom'],
                ]);
            }
            
            $this->dispatch('success');

            return redirect()->route('productSize'); 
        } catch (\Exception $e) {
            $this->dispatch('failed-to-create', ['message' => $e->getMessage()]);
        }
    }


    public function render()
    {
        return view('livewire.product-size.product-size-create', [
            'inventories' => $this->getInventories(),
            'products' => $this->getProducts()
        ]);
    }

    private function getInventories()
    {
        return $this->inventories = Inventory::orderBy('created_at', 'desc')->get();
    }

    private function getProducts()
    {
        return Product::orderBy('name', 'desc')->get();
    }
}
