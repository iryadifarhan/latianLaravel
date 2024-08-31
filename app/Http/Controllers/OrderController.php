<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use App\Models\Order;
use App\Models\Transaction;

class OrderController extends Controller
{
    public function checkout(){
        $user_id = Auth::id();
        $carts = Auth::user()->cart()->get();

        if($carts == null){
            return Redirect::back();
        }

        $order = Order::create([
            'user_id' => $user_id,
            'is_paid' => false
        ]);

        foreach($carts as $cart){
            $product = $cart->product;
            $product->update([
                'stock' => $product->stock - $cart->amount
            ]);

            Transaction::create([
                'product_id' => $cart->product_id,
                'order_id' => $order->id,
                'amount' => $cart->amount
            ]);

            $cart->delete();
        }
        
        return Redirect::route('show_detail_order', $order);
    }

    public function show_order(){
        //todo
        $user = Auth::user();
        $orders = $user->order()->get();

        return view('show_order_list', compact('orders'));
    }

    public function show_detail(Order $order){
        if(!Auth::user()->order()->get()->contains($order) && Auth::user()->is_admin == 0){
            return Redirect::back();
        }
        $transactions = $order->transaction()->get();
        
        $total_price = 0;
        foreach($transactions as $transaction){
            $total_price += $transaction->amount * $transaction->product()->first()->price;
        }

        return view('show_detail_order', compact('order', 'transactions', 'total_price'));
    }

    public function submit_payment(Order $order, Request $request){
        $request->validate([
            'receipt' => 'required',
            'nominal' => 'required|gte:' . $request->price_final
        ]);

        $file = $request->file('receipt');
        $path = time() . '_' . $order->id . '.' . $file->getClientOriginalExtension();

        Storage::disk('local')->put('public/order_receipts/' . $path, file_get_contents($file));

        $order->update([
            'payment_receipt' => $path
        ]);

        return Redirect::back();
    }

    public function show_order_confirmation(){
        $orders = Order::all();
        return view('verify_order', compact('orders'));
    }

    public function confirm_payment(Order $order){
        if($order->payment_receipt == null){
            return Redirect::back()->with('');
        }

        $order->update([
            'is_paid' => true
        ]);

        return Redirect::back();
    }
}
