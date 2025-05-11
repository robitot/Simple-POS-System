<?php

namespace App\Livewire\Products;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductSize;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;
    #[Validate('required|image|mimes:jpeg,png,jpg,gif,svg|max:2048')]
    public $image;
    #[Validate('required|min:5|unique:products,name')]
    public $name;
    #[Validate('required|min:5')]
    public $description;
    #[Validate('required|min:1')]
    public $categoryId = 0;
    #[Validate('required|min:1')]
    public $qty = 0;
    #[Validate('required|min:1')]
    public $price = 0;

    public function create()
    {
        try {
            $this->validate();

            $imagePath = null;
            if ($this->image) {
                $imagePath = $this->image->store('products', 'public');
            }

            $product = Product::create([
                'name' => $this->name,
                'image' => $imagePath,
                'category_id' => $this->categoryId,
                'description' => $this->description,
                'is_active' => true,
                'quantity' => $this->qty,
            ]);

            $productSize = ProductSize::create([
                'name' => 'standard',
                'current_price' => $this->price,
                'previous_price' => $this->price,
            ]);

            $product->sizes()->save($productSize);

            $this->dispatch('drink-successfully-successfully');

            return redirect()->route('products');
        } catch (\Throwable $th) {
            $this->dispatch('drink-failed-to-create');
        }
    }

    public function render()
    {
        return view('livewire.products.create', ['categories' => $this->getCategories()]);
    }

    public function getCategories()
    {
        $categories = Category::get()->all();
        return $categories;
    }
}
