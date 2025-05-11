<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Cache;

class Login extends Component
{
    public $email;
    public $password;
    public $failedAttempts = 0;
    public $cooldownUntil = null;
    public $remainingSeconds = 0;

    public function mount()
    {
        $this->checkCooldown();
    }

    public function checkCooldown()
    {
        $this->failedAttempts = Cache::get('login_attempts_' . request()->ip(), 0);
        $this->cooldownUntil = Cache::get('login_cooldown_' . request()->ip());

        if ($this->isInCooldown() && $this->cooldownUntil) {
            $this->updateRemainingTime();
        } else {
            $this->remainingSeconds = 0;
        }
    }

    private function updateRemainingTime()
    {
        $this->remainingSeconds = now()->diffInSeconds($this->cooldownUntil);
    }

    private function handleFailedAttempt()
    {
        $attemptsKey = 'login_attempts_' . request()->ip();

        $this->failedAttempts = Cache::increment($attemptsKey);

        if ($this->failedAttempts >= 4) {
            $this->cooldownUntil = now()->addSeconds(30);
            Cache::put('login_cooldown_' . request()->ip(), $this->cooldownUntil, 30);
            $this->updateRemainingTime();
            session()->flash('error', "Too many attempts. Please wait 30 seconds.");
        } else {
            session()->flash('error', 'Invalid email or password.');
        }
    }

    private function resetAttempts()
    {
        Cache::forget('login_attempts_' . request()->ip());
        Cache::forget('login_cooldown_' . request()->ip());
        $this->failedAttempts = 0;
        $this->cooldownUntil = null;
    }

    private function isInCooldown()
    {
        $this->cooldownUntil = Cache::get('login_cooldown_' . request()->ip());

        if ($this->cooldownUntil && now()->lessThan($this->cooldownUntil)) {
            return true;
        }

        if ($this->cooldownUntil && now()->greaterThanOrEqualTo($this->cooldownUntil)) {
            // cooldown expired, clean both cooldown and attempts
            Cache::forget('login_cooldown_' . request()->ip());
            Cache::forget('login_attempts_' . request()->ip());
            $this->cooldownUntil = null;
            $this->failedAttempts = 0;
        }

        return false;
    }

    public function authenticate()
    {
        $validated = $this->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($this->isInCooldown()) {
            dump(1);
            $this->updateRemainingTime();
            session()->flash('error', "Too many attempts. Please wait {$this->remainingSeconds} seconds.");
            return;
        }

        $loginField = filter_var($this->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        if (auth()->attempt([
            $loginField => $this->email,
            'password' => $this->password
        ])) {


            if (auth()->user()->is_acive) {

                $this->resetAttempts();

                if (auth()->user()->user_role == 'admin') {
                    return redirect()->route('dashboard');
                } elseif (auth()->user()->user_role == 'admin_assistan') {
                    return redirect()->route('user');
                } elseif (auth()->user()->user_role == 'cashier') {
                    return redirect()->route('session');
                } elseif (auth()->user()->user_role == 'wh') {
                    return redirect()->route('supplyChain');
                }
            }

            $this->error(true);

        }
        $this->handleFailedAttempt();
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
