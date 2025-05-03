<?php

namespace App\Livewire\Auth;

use Livewire\Component;

class Logout extends Component
{
    public function unthenticate()
    {
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->to('/');

    }

    public function render()
    {
        return view('livewire.auth.logout');
    }
}
