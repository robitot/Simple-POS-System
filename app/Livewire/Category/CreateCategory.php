<?php

namespace App\Livewire\Category;

use App\Models\Category;
use Livewire\Component;

class CreateCategory extends Component
{

    public $name;

    public function render()
    {
        return view('livewire.category.create-category');
    }

    public function create()
    {
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
