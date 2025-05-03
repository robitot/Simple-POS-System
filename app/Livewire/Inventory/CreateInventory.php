<?php

namespace App\Livewire\Inventory;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Inventory as ModelsInventory;


class CreateInventory extends Component
{
    use WithFileUploads;
    public $name;
    public $qty;
    public $price;
    public $uom;
    public $image;

    protected $rules = [
        'name' => 'required|string|max:255',
        'qty' => 'required|min:1',
        'price' => 'required|min:0.01',
        'uom' => 'required',
        'image' => 'nullable|image',
    ];

    public function render()
    {
        return view('livewire.inventory.create-inventory');
    }

    public function create()
    {
        $this->validate();
    
        try {
            $imagePath = null;
            if ($this->image) {
                $imagePath = $this->image->store('inventory_images', 'public');
            }
    
            $inventory = ModelsInventory::create([
                'name' => $this->name,
                'quantity' => $this->qty,
                'current_price' => $this->price,
                'previous_price' => $this->price,
                'uom' => $this->uom,
                'image' => $imagePath,
            ]);
    
            if ($inventory) {
                $this->dispatch('success');
                return redirect()->route('inventory');
            } else {
                throw new \Exception("Failed to create inventory record.");
            }
        } catch (\Throwable $th) {
            $this->dispatch('error');
        }
    }
    
}
