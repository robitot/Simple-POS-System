<?php

namespace App\Livewire\Products;

use App\Livewire\Forms\Pagination;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithoutUrlPagination;

class Products extends Component
{

    public Pagination $pagination;

    use WithoutUrlPagination;

    public function render()
    {
        return view('livewire.products.products', [
            'products' => $this->getProducts()
        ]);
    }

    public function getProducts()
    {
        $products = Product::where(function ($query) {
            $query->where('name', 'like', "%{$this->pagination->search}%")
                ->orWhere('id', $this->pagination->search);
        })
            ->orderBy('created_at', 'desc')
            ->paginate($this->pagination->paginate);


        return $products;
    }
}
