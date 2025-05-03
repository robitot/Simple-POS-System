<?php

namespace App\Livewire\POS;

use App\Models\Category;
use App\Models\POSSession;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Pos extends Component
{
    public $carts = [];
    public $search;
    public $currentCategoryId = 0;
    public $cash = 0;
    public $eCash = 0;
    public $startingCash = 0;
    public $totalCash = 0;

    public function render()
    {
        $productsQuery = Product::with(['sizes', 'category'])
            ->whereHas('sizes')
            ->where('is_active', true)
            ->when($this->currentCategoryId != 0, function ($query) {
                $query->where('category_id', $this->currentCategoryId);
            })
            ->when(!empty($this->search), function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            });


        return view('livewire.p-o-s.pos', [
            'products' => $productsQuery->get(),
            'categories' => Category::all(),
        ]);
    }

    public function filterByCategory($id)
    {
        $this->currentCategoryId = $id;
    }

    public function mount()
    {
        if (Session::has('carts')) {
            $this->carts = Session::get('carts');
        }

        $recentSession = POSSession::with('orders')->latest()->first();
        if ($recentSession == null) return redirect()->route('POS.start-session');

        $this->startingCash = $recentSession->starting_cash;
        $this->cash = $recentSession->orders->where('mop', 'cash')->sum('total_amount');
        $this->eCash = $recentSession->orders->where('mop','!=', 'cash')->sum('total_amount');
        $this->totalCash = $this->startingCash + $this->cash + $this->eCash;


        if (!$recentSession->status) return redirect()->route('POS.start-session');
    }

    public function addToCart($product, $size)
    {
        foreach ($this->carts as &$cartItem) {
            if ($cartItem['size']['id'] == $size['id']) {
                $cartItem['quantity'] += 1;
                return;
            }
        }

        $this->carts[] = [
            'product' => $product,
            'price' => $size['current_price'],
            'quantity' => 1,
            'size' => $size
        ];
    }


    public function remove($productId, $sizeId)
    {
        $this->carts = collect($this->carts)->reject(function ($item) use ($productId, $sizeId) {
            return $item['product']['id'] == $productId && $item['size']['id'] == $sizeId;
        })->toArray();
        $this->dispatch('product-removed-successfully');
    }

    public function decrementAndIncreament($isIncreament, $productId, $sizeId)
    {
        foreach ($this->carts as $index => $item) {
            if ($item['product']['id'] == $productId && $item['size']['id'] == $sizeId) {
                if ($isIncreament) {
                    $this->carts[$index]['quantity'] += 1;
                } else {
                    if ($this->carts[$index]['quantity'] > 1) {
                        $this->carts[$index]['quantity'] -= 1;
                    } else {
                        unset($this->carts[$index]);
                        $this->carts = array_values($this->carts);
                    }
                }
                break;
            }
        }
    }

    public function checkout()
    {
        Session::put('carts', $this->carts);

        return redirect()->route('POS.checkout');
    }

    public function clearCart()
    {
        Session::forget('carts');
        $this->carts = null;
        $this->dispatch('cart-clear-successfully');

    }
}
