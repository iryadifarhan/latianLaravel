@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row-sm mx-5">
            <div class="card mx-5">
                <div class="card-header py-2">
                    Detail Produk
                </div>
                <div class="card-body px-5 my-1">
                    <div class="d-flex justify-content-around ">
                        <div class="image my-auto">
                            <img src="{{Storage::url('product_images/'.$product->image)}}" alt="gambar_produk" width='300px'>
                        </div>
                        <div class="info me-5">
                            <h1>{{$product->name}}</h1>
                            <h5>{{$product->description}}</h5>
                            <p>Rp.{{$product->price}},-</p>
                            <hr>
                            </p>Stok Produk: {{$product->stock}}</p>

                            <div class="row">
                                <div class="col-6 pe-0">
                                    <form action="{{route('createCart',$product)}}" method="post">
                                    @csrf
                                    <div class="input-group">
                                        <button class="btn btn-outline-secondary" name="jumlahController" value='minus' type="submit">-</button>
                                        <input type="number" name="jumlah" class="form-control" value={{$angka}} aria-label="Example text with two button addons">
                                        <button class="btn btn-outline-secondary" name="jumlahController" value='plus' type="submit">+</button>
                                    </div><br>
                                    
                                    @if($errors->any())
                                        @foreach($errors->all() as $error)
                                            <p>{{$error}}</p>
                                        @endforeach
                                    @endif

                                    @if(isset(Auth::user()->id) && isset(Auth::user()->cart()->where('product_id',$product->id)->first()->amount))
                                        <input type="hidden" name="amount" value={{Auth::user()->cart()->where('product_id',$product->id)->first()->amount}}>   
                                    @endif
                                    
                                    @if($product->stock <= 0)
                                        <button type="submit" class="btn btn-success" disabled>Add to cart</button>
                                    @else
                                        <button type="submit" class="btn btn-success">Add to cart</button>
                                    @endif
                                </form>
                                
                                </div>
                                @if(Auth::user()->is_admin)
                                    <div class="col-4 ps-0 mt-auto">
                                        <a href="{{route('showEditProduct', $product)}}"><button class="btn btn-warning">Edit Product</button></a>
                                    </div>
                                @endif
                            </div>
                            <a href="{{route('showAllProduct')}}" ><button class="btn btn-primary my-2">Kembali</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
@endsection