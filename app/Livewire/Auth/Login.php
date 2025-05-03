<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public $email;
    public $password;

    public function authenticate()
    {
        $validated = $this->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (auth()->attempt($validated)) {

            if (auth()->user()->is_acive) {
                if (auth()->user()->user_role == 'admin') {
                    return redirect()->route('dashboard');
                }
                elseif(auth()->user()->user_role == 'admin_assistan')
                {
                    return redirect()->route('user');
                }
                elseif(auth()->user()->user_role == 'cashier')
                {
                    return redirect()->route('session');
                }
                elseif(auth()->user()->user_role == 'wh')
                {
                    return redirect()->route('supplyChain');
                }
            }
            $this->error(true);
        } else {
            $this->error(false);
        }
    }

    public function render()
    {
        return view('livewire.auth.login');
    }

    private function error($isInactive)
    {
        if ($isInactive) {
            auth()->logout();
        }
        session()->flash('error', 'Invalid email or password.');
    }
}
