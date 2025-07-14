<?php

namespace App\Livewire\Auth;

use Livewire\Component;

class VerifyCode extends Component
{

    public $code;

    public function render()
    {
        return view('livewire.auth.verify-code');
    }

    public function mount()
    {
        $this->code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    }
}
