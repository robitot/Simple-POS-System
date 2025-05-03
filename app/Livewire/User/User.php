<?php

namespace App\Livewire\User;

use App\Livewire\Forms\Pagination;
use App\Models\User as ModelsUser;
use Livewire\Component;
use Livewire\WithPagination;

class User extends Component
{

    use WithPagination;

    public $search;
    public $paginate = 5;
    public $sor = 'desc';
    public Pagination $pagination;

    
    public function render()
    {
        $users = $this->getUsers();
        return view('livewire.user.user', [
            'users' => $users,
        ]);
    }

    private function getUsers()
    {
        $user = ModelsUser::with('userDetails')
            ->where('store_id', '=', auth()->user()->store_id)
            ->where('name', 'like', "%{$this->pagination->search}%")
            ->paginate($this->pagination->paginate);

        return $user;
    }

    public function isActive($id)
    {
        $user = ModelsUser::find($id);
        
        if ($user) {
            $user->is_acive = !$user->is_acive;
    
            $user->save();
        }
    }
    
}
