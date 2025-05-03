<?php

namespace App\Livewire\User;

use App\Models\User;
use App\Models\UserDetails;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateUser extends Component
{
    use WithFileUploads;
    #[Validate('required|min:5')]
    public $fullName;
    #[Validate('required')]
    public $email;
    #[Validate('required')]
    public $password;
    #[Validate('required|same:password')]
    public $confirmPassword;
    #[Validate('required')]
    public $role;
    #[Validate('required')]
    public $phone;
    #[Validate('required')]
    public $address;
   

    public function create()
    {
        $this->validate();

        try {

            DB::transaction(function () {

                $user = User::create([
                    'name' => $this->fullName,
                    'email' => $this->email,
                    'password' => Hash::make($this->password),
                    'store_id' => auth()->user()->store_id,
                    'user_role' => $this->role
                ]);

                $userDetails = new UserDetails([
                    'address' => $this->address,
                    'avatar' => null,
                    'phone' => $this->phone,
                ]);

                $user->userDetails()->save($userDetails);
            });

            $this->dispatch('user-successfully-successfully');

            redirect()->route('user');
        } catch (\Throwable $th) {
            $this->dispatch('user-failed-to-create');
        }
    }

    public function render()
    {
        return view('livewire.user.create-user');
    }
}
