<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Product;
use App\Models\Cart;

class CartController extends Controller
{
    public function create_cart(Product $product, Request $request){
        $user = Auth::user();
        $cart = $user->cart()->where('product_id',$product->id)->where('user_id',$user->id)->first();
        
        //logika untuk tombol plus & minus
        $angka = $request->jumlah;
        if($request->jumlahController == 'plus'){
            $request->validate([
                'jumlah' => 'lt:'.$product->stock
            ],
            [
                'lt' => 'Stok barang tidak mencukupi'
            ]);
            $angka = $request->jumlah + 1;
            return Redirect::route('showDetailProduct', compact('product', 'angka'));
        }else if($request->jumlahController ==  'minus'){
            $request->validate([
                'jumlah' => 'gt:1'
            ]);
            $angka -= 1;
            return Redirect::route('showDetailProduct', compact('product', 'angka'));
        }

        //logika jika angka yang diinput oleh user melalui ketikan tidak sesuai
        if($request->jumlah > $product->stock)
            $request->jumlah = $product->stock;
        else if($request->jumlah < 0)
            $request->jumlah = 0;

        //logika validasi pembuatan cart
        if($cart == null && $product->stock > 0){
            Cart::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'amount' => $request->jumlah
            ]);
        }else{  //jika cart sudah ada maka update saja tidak perlu membuat ulang 
            $request->validate([
                'amount' => 'required|lte:' . ($product->stock - $request->jumlah)
            ],
            [
                'amount' => 'Sepertinya stok barang sedang habis',
                'lt' => "Sepertinya qty barang ini sudah maksimum di cartmu"
            ]);

            $cart->update([
                'amount' => $cart->amount + $request->jumlah
            ]);
            
        }

        return Redirect::back();
    }

    public function show_cart(){
        $user = Auth::user();
        $carts = [];

        if($user != null)
            $carts = $user->cart()->get();

        return view('show_cart_lists',compact('carts'));
    }

    public function change_to_cart(Cart $cart, Request $request){
        
        if($request->quantityController == 'plus'){
            $request->validate([
                'amount' => 'required|lt:' . ($cart->product->stock)
            ],
            [
                'amount.lt' => $cart->id    //custom error message untuk 'less than'
            ]);

            $cart->update([
                'amount' => ++$cart->amount
            ]);
        }else if($request->quantityController == 'minus'){
            $cart->update([
                'amount' => --$cart->amount
            ]);

            if($cart->amount <= 0){
                self::delete_cart($cart);
            }
        }

        return Redirect::back();
    }

    public function delete_cart(Cart $cart){
        $cart->delete();
        
        return Redirect::back();
    }
}
