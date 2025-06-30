<?php

namespace App\Livewire\Session;

use App\Models\POSOrderItems;
use App\Models\POSOrders;
use Livewire\Component;
use Livewire\WithPagination;
use App\Livewire\Forms\Pagination;
use Illuminate\Pagination\LengthAwarePaginator;

class Details extends Component
{
    use WithPagination;

    public Pagination $pagination;
    public $orderId;

    public function mount($id)
    {
        $this->orderId = $id;
    }

    public function render()
    {
        // Get all orders with their items
        $POSOrders = POSOrders::with('orderItems')->where('pos_session_id', $this->orderId)->get();

        // Flatten all order items into a single collection
        $allOrderItems = $POSOrders->flatMap(function ($order) {
            return $order->orderItems->map(function ($item) use ($order) {
                $item->pos_order_id = $order->id; // Attach pos_order_id to each item
                return $item;
            });
        });

        // Apply search filter
        $filtered = $allOrderItems->filter(function ($item) {
            $search = strtolower($this->pagination->search);

            return str_contains(strtolower($item->product_name), $search)
                || (string) $item->id === $search
                || (string) $item->pos_order_id === $search;
        });

        // Sort by qty as integer (desc)
        $sorted = $filtered->sortByDesc(fn($item) => (int) $item->qty);

        // Manual pagination
        $perPage = $this->pagination->paginate;
        $currentPage = request()->get('page', 1);
        $paged = new LengthAwarePaginator(
            $sorted->forPage($currentPage, $perPage)->values(),
            $sorted->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('livewire.session.details', [
            'orders' => $paged
        ]);
    }
}
