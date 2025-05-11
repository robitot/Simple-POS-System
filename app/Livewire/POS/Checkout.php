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


    public function render()
    {
        return view('livewire.p-o-s.checkout', ['carts' => Session::get('carts')]);
    }

    public function placeOrder()
    {
        $posSession = POSSession::where('status', true)->first();
        $carts = Session::get('carts');

        // Validation
        if (!$posSession || !$this->mop || ($this->mop !== 'cash' && empty($this->referenceNo)) || empty($carts)) {
            session()->flash('error', 'Invalid order details.');
            return;
        }

        DB::beginTransaction();

        try {
            $order = POSOrders::create([
                'pos_session_id' => $posSession->id,
                'mop' => $this->mop,
                'reference_number' => $this->referenceNo,
                'total_amount' => collect($carts)->sum(fn($cart) => $cart['quantity'] * $cart['size']['current_price']),
            ]);

            foreach ($carts as $cart) {
                POSOrderItems::create([
                    'pos_order_id' => $order->id,
                    'product_name' => $cart['product']['name'],
                    'qty' => $cart['quantity'],
                    'size' => $cart['size']['name'],
                    'price' => $cart['size']['current_price'],
                    'total_amount' => $cart['quantity'] * $cart['size']['current_price'],
                ]);

                $product = Product::find($cart['product']['id']);
                $product->quantity = $product->quantity - $cart['quantity'];
                $product->save();
            }

            DB::commit();
            Session::forget('carts');
            return redirect()->route('POS')->with('success', 'Order placed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Order failed: ' . $e->getMessage());
        }
    }
}
