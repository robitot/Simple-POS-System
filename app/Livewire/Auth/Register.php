<?php

namespace App\Livewire\Auth;

use App\Livewire\Forms\RegisterForm;
use App\Models\Store;
use App\Models\User;
use App\Models\UserDetails;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class Register extends Component
{
    use WithFileUploads;

    public RegisterForm $register;

    public $page = 1;

    public function nextPage($isNext)
    {
        // if ($isNext) {
        //     $this->validate($this->rules());
        // }
        $isNext ? $this->page++ : $this->page--;
    }

    protected function rules()
    {
        // switch ($this->page) {
        //     case 1:
        //         return [
        //             'email' => 'required|email|unique:users,email|max:255',
        //             'password' => 'required|string|min:8',
        //         ];
        //     case 2:
        //         return [
        //             'fullName' => 'required|min:3|max:20',
        //             'address' => 'required',
        //             'avatar' => 'required|image|max:1024',
        //             'phone' => 'required|min:10',
        //         ];
        //     case 3:
        //         return [
        //             'storeName' => 'required',
        //             'logo' => 'required|image|max:2048',
        //         ];
        // }
    }

    public function createAccount()
    {

        DB::transaction(function () {
            $avatar = $this->register->avatar->store('avatars', 'public');
            $logo = $this->register->logo->store('logos', 'public');

            $user = User::create([
                'name' => $this->register->fullName,
                'email' => $this->register->email,
                'password' => Hash::make($this->register->password),
            ]);

            $userDetails = new UserDetails([
                'address' => $this->register->address,
                'avatar' => $avatar,
                'phone' => $this->register->phone,
            ]);

            $store = Store::create([
                'name' => $this->register->storeName,
                'logo' => $logo,
            ]);

            $user->store()->save($store);
            $user->userDetails()->save($userDetails);
        });

        // $this->reset('fullName', 'email', 'password');
        request()->session()->flash('success', 'Account Created Successfully');
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
