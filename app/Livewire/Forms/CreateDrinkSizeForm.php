<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateDrinkSizeForm extends Form
{
    #[Validate('required')]
    public $name;

    #[Validate('required|min:1')]
    public $qty;

    #[Validate('required|min:1')]
    public $uom;

    #[Validate('required|min:1')]
    public $price;
}
