<?php

namespace App\Livewire\POS;

use App\Models\Inventory;
use App\Models\POSOrderItems;
use App\Models\POSOrders;
use App\Models\POSSession;
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
        // 1. Create the Order
        $order = POSOrders::create([
            'pos_session_id' => $posSession->id,
            'mop' => $this->mop,
            'reference_number' => $this->referenceNo,
            'total_amount' => collect($carts)->sum(fn($cart) => $cart['quantity'] * $cart['size']['current_price']),
        ]);

        // 2. Process Order Items and Inventory
        foreach ($carts as $cart) {
            // Create order item
            POSOrderItems::create([
                'pos_order_id' => $order->id,
                'product_name' => $cart['product']['name'],
                'qty' => $cart['quantity'],
                'size' => $cart['size']['name'],
                'price' => $cart['size']['current_price'],
                'total_amount' => $cart['quantity'] * $cart['size']['current_price'],
            ]);

            // Get the product size with its items
            $productSize = ProductSize::with('productSizeItems')
                ->find($cart['size']['id']);

            if (!$productSize) {
                throw new \Exception("Product size not found: {$cart['size']['id']}");
            }

            // Process each inventory item
            foreach ($productSize->productSizeItems as $sizeItem) {
                $inventory = Inventory::lockForUpdate()->find($sizeItem->inventory_id);
                
                if (!$inventory) {
                    throw new \Exception("Inventory not found: {$sizeItem->inventory_id}");
                }

                // Calculate quantity to deduct (adjust the /1000 if needed for your units)
                $quantityToDeduct = ($sizeItem->quantity * $cart['quantity']);

                // Verify sufficient stock
                if ($inventory->quantity < $quantityToDeduct) {
                    throw new \Exception("Insufficient stock for {$inventory->name}. Available: {$inventory->quantity}, Needed: {$quantityToDeduct}");
                }

                // Update inventory
                $inventory->decrement('quantity', $quantityToDeduct);
            }
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
