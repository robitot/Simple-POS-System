<?php

namespace App\Livewire\POS;

use App\Livewire\Auth\Logout;
use App\Models\POSSession;
use Livewire\Component;
use Carbon\Carbon;

class EndSession extends Component
{

    private $auth;

    public function __construct()
    {
        $this->auth = app(Logout::class);
    }

    public $endingCash = 0;

    public function render()
    {
        return view('livewire.p-o-s.end-session');
    }

    public function endPOS()
    {
        $today = Carbon::today();
        $sales = POSSession::with('orders')->latest()->first();

        $totalSales = $sales->orders->sum('total_amount') + $sales->starting_cash;

        if ($this->endingCash < $totalSales) {
            session()->flash('error', 'Ending cash cannot be less than total sales');
            return;
        }

        $sales->status = false;
        $sales->ending_cash = $this->endingCash;
        $sales->save();

        if (Auth()->user()->user_role == 'admin') {
            return redirect()->route('dashboard');
        } else {
            $this->auth->unthenticate();
        }
    }
}
