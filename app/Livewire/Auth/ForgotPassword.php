<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ForgotPassword extends Component
{

    public $code;

    public function render()
    {
        return view('livewire.auth.forgot-password');
    }

    public function mount()
    {
       $user = Auth::user();

       if($user->code == null)
       {
        
       }
    }

    public function verifyCode()
    {
       $user = Auth::user();

       if($this->code == $user->code)
       {

       }
    }
}
