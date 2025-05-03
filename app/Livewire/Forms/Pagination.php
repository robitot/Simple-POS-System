<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class Pagination extends Form
{
    public $search;
    public $paginate = 5;
    public $sort = 'desc';
}
