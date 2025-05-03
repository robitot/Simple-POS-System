<?php

namespace App\Livewire\ProductSize;

use App\Livewire\Forms\Pagination;
use App\Models\ProductSize as ModelsProductSize;
use Livewire\Component;
use Livewire\WithoutUrlPagination;

class ProductSize extends Component
{

    use WithoutUrlPagination;

    public Pagination $pagination;

    public function getSizes()
    {
        $sizes = ModelsProductSize::where('name', 'like', "%{$this->pagination->search}%")
        ->orderBy('created_at', 'desc')
        ->paginate($this->pagination->paginate);

        return $sizes;
    }

    public function render()
    {
        $sizes = $this->getSizes();
        return view('livewire.product-size.product-size', [
            'sizes' => $sizes,
        ]);
    }
}
