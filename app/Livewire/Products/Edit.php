<?php

namespace App\Livewire\Products;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductSize;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{

    use WithFileUploads;
    #[Validate('required')]
    public $image;
    #[Validate('required|min:5|unique:products,name')]
    public $name;
    #[Validate('required|min:5')]
    public $description;
    public $isActive;
    public $id;
    public $newImg;
    #[Validate('required')]
    public $categoryId;
    #[Validate('required|min:1')]
    public $qty = 0;
    #[Validate('required|min:1')]
    public $price = 0;

    public function mount($productId)
    {
        $product = Product::find($productId);
        $this->id = $product->id;
        if ($product == null) {
            return redirect()->route('inventory');
        }

        if ($product) {
            $this->name = $product->name;
            $this->image = $product->image;
            $this->description = $product->description;
            $this->isActive = $product->is_active;
            $this->categoryId = $product->category_id;
            $this->qty = $product->quantity;
            $this->price = $product->sizes[0]->current_price;
        }
    }

    public function edit()
    {
        try {
            $this->validate();

            $product = Product::find($this->id);

            if ($product) {
                $product->name = $this->name;
                $product->image = $this->image;
                $product->description = $this->description;
                $product->is_active = $this->isActive;
                $product->category_id = $this->categoryId;
                $product->quantity = $this->qty;

                if ($this->newImg != null) {
                    Storage::disk('public')->delete($product->image);
                    $imagePath = $this->newImg->store('products', 'public');
                    $product->image = $imagePath;
                }

                $product->save();
                $size = ProductSize::find($product->sizes[0]->id);
                $size->current_price = $this->price;
                $size->save();
                $this->dispatch('drink-edited-successfully');

                return redirect()->route('products');
            } else {
                $this->dispatch('drink-failed-to-edit');
            }
        } catch (\Throwable $th) {
            $this->dispatch('drink-failed-to-edit');
        }
    }

    public function render()
    {
        return view('livewire.products.edit', ['categories' => $this->getCategories()]);
    }

    public function getCategories()
    {
        $categories = Category::get()->all();

        return $categories;
    }
}
