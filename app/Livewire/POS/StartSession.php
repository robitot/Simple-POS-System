<?php

namespace App\Livewire\POS;

use App\Models\POSSession;
use Livewire\Component;

class StartSession extends Component
{
    public $starting_cash;

    public function render()
    {
        return view('livewire.p-o-s.start-session');
    }

    public function startPOS()
    {
        $this->validate([
            'starting_cash' => 'required|numeric|min:1'
        ]);

        POSSession::create([
            'starting_cash' => $this->starting_cash,
            'ending_cash' => 0,
            'status' => 1
        ]);

        return redirect()->route('POS');
    }
}
