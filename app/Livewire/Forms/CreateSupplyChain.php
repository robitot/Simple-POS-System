<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateSupplyChain extends Form
{
    #[Validate('required|min:5')]
    public $inCharge;

    #[Validate('required|min:5')]
    public $receipt;

    #[Validate('required|min:5')]
    public $amount;
}
