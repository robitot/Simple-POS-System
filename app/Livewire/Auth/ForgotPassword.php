<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Mail\sendCode;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

class ForgotPassword extends Component
{

    public string $email;
    public $password;
    public $confirmPassword;
    public $page = 1;
    public $user;
    public $userCode;

    public function render()
    {
        return view('livewire.auth.forgot-password');
    }

    // public function mount()
    // {
    //     $this->code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    // }


    public function verifyEmail()
    {
        $this->user = User::where('email', $this->email)->first();

        if ($this->user) {
            $code = rand(100000, 999999);

            $this->user->code = $code;
            $this->user->save();

            Mail::to($this->user->email)->send(new sendCode($this->user->code));
            $this->page = 2;
            return;
        }

        session()->flash('error', "Invalid Email");
    }

    public function verifyCode()
    {
        if ($this->user->code == $this->userCode) {
            $this->page = 3;
            return;
        }

        return session()->flash('error', "Invalid code");
    }

    public function changePassword()
    {

        if ($this->password !== $this->confirmPassword) {
            session()->flash('error', 'Password does not match the confirmation.');
            return;
        }

        $this->user->password = Hash::make($this->password);
        $this->user->code = null;
        $this->user->save();

        session()->flash('success', 'Password changed successfully.');

        return redirect()->route('login');
    }
}
