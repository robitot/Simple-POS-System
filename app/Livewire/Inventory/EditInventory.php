<?php

namespace App\Livewire\Inventory;

use App\Models\Inventory;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditInventory extends Component
{

    use WithFileUploads;
    public $name;
    public $qty;
    public $price;
    public $uom;
    public $image;
    public $newImg;
    public $id;

    public function mount($inventoryId)
    {
        $inventory = Inventory::find($inventoryId);
        $this->id = $inventory->id;

        if ($inventory == null) {
            return redirect()->route('inventory');
        }

        if ($inventory) {
            $this->name = $inventory->name;
            $this->qty = $inventory->quantity;
            $this->price = $inventory->current_price;
            $this->uom = $inventory->uom;
            $this->image = $inventory->image;
        }
    }

    public function edit()
    {

        $this->validate([
            'name' => 'required',
            'qty' => 'required',
            'price' => 'required',
            'uom' => 'required',
        ]);


        $inventory = Inventory::find($this->id);

        if ($inventory) {
            // Update the inventory record
            $inventory->name = $this->name;
            $inventory->quantity = $this->qty;
            $inventory->current_price = $this->price;
            $inventory->uom = $this->uom;

            if ($this->newImg != null) {
                // Storage::disk('public')->delete($inventory->image);
                $imagePath = $this->newImg->store('inventory_images', 'public');
                $inventory->image = $imagePath;
            }

            // Save the updated inventory record
            $inventory->save();

            // session()->flash('message', 'Inventory updated successfully!');
              $this->dispatch('sucess');

              return redirect()->route('inventory');

            // Optionally, you can redirect or emit events here
        } else {
            session()->flash('error', 'Inventory item not found!');
        }
    }



    public function render()
    {
        return view('livewire.inventory.edit-inventory');
    }
}
