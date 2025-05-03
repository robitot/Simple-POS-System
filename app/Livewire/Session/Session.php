<?php

namespace App\Livewire\Session;

use App\Livewire\Forms\Pagination;
use App\Models\POSSession;
use Livewire\Component;
use Livewire\WithoutUrlPagination;

class Session extends Component
{
    use WithoutUrlPagination;

    public Pagination $pagination;

    public function render()
    {
        return view('livewire.session.session', ['sessions' => $this->getSizes()]);
    }

    public function getSizes()
    {
        $sessions = POSSession::where('id', 'like', "%{$this->pagination->search}%")
            ->orderBy('created_at', 'desc')
            ->paginate($this->pagination->paginate);

        return $sessions;
    }
}
