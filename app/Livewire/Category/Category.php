<?php

namespace App\Livewire\Category;

use App\Livewire\Forms\Pagination;
use App\Models\Category as ModelsCategory;
use Livewire\Component;
use Livewire\WithoutUrlPagination;

class Category extends Component
{

    use WithoutUrlPagination;
    public Pagination $pagination;

    public function render()
    {
        return view('livewire.category.category', ['categories' => $this->getCategories()]);
    }

    public function getCategories()
    {
        $categories = ModelsCategory::where('name', 'like', "%{$this->pagination->search}%")
            ->orderBy('created_at', 'desc')
            ->paginate($this->pagination->paginate);

        return $categories;
    }
}
