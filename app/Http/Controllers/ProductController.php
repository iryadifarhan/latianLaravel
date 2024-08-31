<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;

class ProductController extends Controller
{
    public function displayUI(){
        return view('create_product');
    }

    public function addProduct(Request $request){
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'description' => 'required',
            'image' => 'required|mimes:png,jpg,jpeg',
            'stock' => 'required'
        ]);

        $file = $request->file('image');
        $file_name = $request->name;
        $path = time() . '_' . $file_name . '.' . $file->getClientOriginalExtension();

        Storage::disk('local')->put('public/product_images/'.$path, file_get_contents($file));

        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'image' => $path,
            'stock' => $request->stock
        ]);

        return Redirect::route('showAllProduct');
    }

    public function show_product(){
        $products = Product::all();

        return view('show_product', compact('products'));
    }

    public function show_detail(Product $product, $angka){
        if($angka > $product->stock)
            $angka = $product->stock;
        else if($angka < 0)
            $angka = 0;
        return view('show_detail_product', compact('product', 'angka'));
    }

    public function show_edit(Product $product){
        return view('edit_product', compact('product'));
    }

    public function update_product_data(Product $product, Request $request){
        $file = $request->file('image');
        $path = $product->image;

        if($file != null){
            $path = time() . "_" . $request->name . "." . $file->getClientOriginalExtension();
    
            Storage::delete('public/product_images/'.$product->image);
            Storage::disk('local')->put('public/product_images/'.$path, file_get_contents($file));
        }

        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
            'image' => $path
        ]);

        return Redirect::back();
    }

    public function delete_product_data(Product $product){
        Storage::delete('public/product_images/'.$product->image);
        $product->delete();

        return Redirect::route('showAllProduct');
    }
}
