<?php

namespace App\Livewire\Auth;

use App\Models\Store;
use App\Models\User as ModelUser;
use App\Models\UserDetails;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;


class Profile extends Component
{
    use WithFileUploads;

    public ModelUser $userModel;
    public UserDetails $userDetails;
    public Store $store;

    //user
    public $name;

    //userDetails
    public $avatar;
    public $newAvatar;
    public $address;
    public $phone;

    //store
    public $storeName;
    public $newLogo;
    public $logo;

    public $isLoading = true;

    public function mount()
    {
        $this->getUserDetails();
        $this->isLoading = false;
    }

    public function getUserDetails()
    {
        $user = ModelUser::with(['userDetails', 'store'])
            ->where('id', auth()->user()->id)
            ->first();

        if ($user) {
            $this->userModel = $user;
            $this->userDetails = $user->userDetails;
            $this->store = $user->store;

            $this->name = $user->name;
            $this->avatar = $user->userDetails->avatar;
            $this->address = $user->userDetails->address;
            $this->phone = $user->userDetails->phone;
            $this->storeName = $user->store->name;
            $this->logo = $user->store->logo;
        } else {
            //add redirection and toast notifcaiton of profile not found
        }
    }

    public function editProfile()
    {
        // add validation
        try {
            $this->userModel->name = $this->name;
            $this->userDetails->address = $this->address;
            $this->userDetails->phone = $this->phone;
            $this->store->name = $this->storeName;

            $this->upload();
            $this->userModel->save();
            $this->userDetails->save();
            $this->store->save();

            $this->dispatch('profile-edit-sucess');
            $this->getUserDetails();
        } catch (\Throwable $th) {
            $this->dispatch('profile-edit-failed');
        }
    }

    private function upload()
    {
        if ($this->newAvatar != null) {
            //delete the old avatar
            Storage::disk('public')->delete($this->userDetails->avatar);
            $avatar = $this->newAvatar->store('avatars', 'public');

            $this->userDetails->avatar = $avatar;
        }

        if ($this->newLogo != null) {
            //delete the old logo
            Storage::disk('public')->delete($this->store->logo);
            $logo = $this->newLogo->store('logos', 'public');

            $this->store->logo = $logo;
        }
    }

    public function render()
    {
        return view('livewire.auth.profile');
    }
}
