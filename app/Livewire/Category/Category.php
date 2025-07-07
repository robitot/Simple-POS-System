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
    public $categoryId;

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

    public function deleteCategory()
    {
        $category = \App\Models\Category::find($this->categoryId);

        if ($category) {
            $category->delete();
            $this->dispatch('category-successfully-deleted');
        } else {
            $this->dispatch('category-failed-to-delete');
        }

        $this->categoryId = null;
    }
}
