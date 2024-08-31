@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row-md mx-auto">
            <div class="card mx-5">
                <div class="card-header ps-4">
                    Cart
                </div>
                <div class="card-body">
                    @if(Auth::check() == false)
                        <p>Silakan login terlebih dahulu untuk mengecek cart mu</p>
                    @elseif(count($carts) <= 0)
                        <p>wah sepertinya cart kamu kosong</p>
                    @else   <!-- udh ada barang di cart-->
                        <div class="row">

                            @foreach($carts as $cart)
                                <div class="col-4 ">
                                    <div class="card mx-auto mb-2">
                                        <div class="mx-auto p-3 pb-2">
                                            <img class="rounded mx-auto d-block w-100 mw-30" src="{{Storage::url('product_images/'.$cart->product->image)}}" alt="gambar_produk" height='250px'>
                                            <h4 class="form-label mt-2">{{$cart->product->name}}</h4>
                                            <p>Price per qty: Rp.{{$cart->product->price}}</p>

                                            <form action="{{route('changeCartQty', $cart)}}" method="post">
                                                @csrf
                                                <label for="qty_{{$cart->product->id}}" class="form-label">Quantity</label>
                                                <div class="input-group">
                                                    @if($cart->amount > 1)
                                                        <button class="btn btn-outline-secondary" name="quantityController" type="submit" value="minus">-</button>
                                                    @else
                                                        <button class="btn btn-outline-secondary " name="quantityController" type="submit" value="minus">hapus</button>
                                                    @endif
                                                    <input id="qty_{{$cart->product->id}}" type="number" name="jumlah" class="form-control" value={{$cart->amount}} readonly>
                                                    <button class="btn btn-outline-secondary " name="quantityController" type="submit" value="plus">+</button>
                                                </div>
                                                <input type="hidden" name="amount" value={{$cart->amount}}>   <!-- memberikan parameter terhadap form berupa jumlah quantity pada cart tersebut -->
                                            </form>
                                            <br>
                                            @if($errors->any())
                                                @foreach($errors->all() as $error)
                                                    @if($cart->id == $error)    <!-- untuk pengecekan apakah cart tersebut merupakan cart yang terjadi errror -->
                                                    <div class="alert alert-danger" role="alert">
                                                        The amount of quantity can't exceed the total stock of product <b>({{$cart->product->stock}})</b>
                                                    </div>
                                                    @endif
                                                @endforeach
                                            @endif
                                            
                                            <p><b>Total pricing: Rp.{{$cart->amount * $cart->product->price}}</b></p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                
                        <form action="{{route('checkout')}}" method="post">
                            @csrf
                            <button class="btn btn-success mt-2" type="submit">Checkout</button>
                        </form>
                </div>
            </div>
        </div>
    </div>

    @endif
@endsection