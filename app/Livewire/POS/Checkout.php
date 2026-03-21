<?php

namespace App\Livewire\POS;

use App\Models\Inventory;
use App\Models\POSOrderItems;
use App\Models\POSOrders;
use App\Models\POSSession;
use App\Models\Product;
use App\Models\ProductSize;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Illuminate\Support\Facades\DB;


class Checkout extends Component
{

    public $mop;
    public $amount;
    public $referenceNo;
    public $tableNumber = null;
    public $receiptNumber = null;
    public $applyDiscount = false;
    public $carts = [];

    public function render()
    {
        $sessionCarts = Session::get('carts', []);

        if (!empty($sessionCarts)) {
            $this->carts = $sessionCarts;
        }

        return view('livewire.p-o-s.checkout', ['carts' => $this->carts]);
    }

    public function mount()
    {
        $nextId = POSOrders::max('id') + 1;
        $this->receiptNumber = $nextId;
    }

    public function placeOrder()
    {
        $posSession = POSSession::where('status', true)->first();
        $carts = $this->carts ?: Session::get('carts', []);

        // Validation
        if (!$posSession || !$this->mop || ($this->mop !== 'cash' && empty($this->referenceNo)) || empty($carts)) {
            session()->flash('error', 'Invalid order details.');
            return;
        }

        DB::beginTransaction();

        try {
            $rawTotal = collect($carts)->sum(fn($cart) => $cart['quantity'] * $cart['size']['current_price']);
            $finalTotal = $this->applyDiscount ? $rawTotal * 0.8 : $rawTotal;

            $order = POSOrders::create([
                'pos_session_id' => $posSession->id,
                'mop' => $this->mop,
                'reference_number' => $this->referenceNo,
                'total_amount' => $finalTotal, // ✅ Use discounted total
            ]);

            foreach ($carts as $cart) {
                POSOrderItems::create([
                    'pos_order_id' => $order->id,
                    'product_name' => $cart['product']['name'],
                    'qty' => $cart['quantity'],
                    'size' => $cart['size']['name'],
                    'price' => $cart['size']['current_price'],
                    'total_amount' => $cart['quantity'] * $cart['size']['current_price'], // this is per item line, raw is OK
                ]);

                $product = Product::find($cart['product']['id']);
                $product->quantity -= $cart['quantity'];
                $product->save();
            }

            DB::commit();
            Session::forget('carts');
            $this->carts = $carts;
            $this->dispatch('success-order');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Order failed: ' . $e->getMessage());
        }
    }
}
