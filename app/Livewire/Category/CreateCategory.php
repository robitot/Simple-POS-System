<?php

namespace App\Livewire\Category;

use App\Models\Category;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreateCategory extends Component
{

    #[Validate('required|min:5|unique:categories,name')]
    public $name;

    public function render()
    {
        return view('livewire.category.create-category');
    }

    public function create()
    {
        $this->validate();
        try {
            Category::create([
                'name' => $this->name,
            ]);
            $this->dispatch('success');
            return redirect()->route('category');
        } catch (\Throwable $th) {
            $this->dispatch('error');
        }
    }
}
