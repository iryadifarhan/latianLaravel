@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    Produk-produk
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($products as $product)
                            <div class="col-3">
                                <div class="card">
                                    <div class="card-body">
                                        <img class="rounded mx-auto d-block w-100 mw-30" src="{{Storage::url('product_images/' .$product->image)}}" alt="gambar_produk" height="250px">
                                        <p class="form-label my-2">Produk {{$product->name}}</p>
                                        <form action="{{route('showDetailProduct', [$product,'1'])}}" method="get">
                                            @csrf
                                            <button class="btn btn-success" type="submit">Cek lebih detail</button>
                                        </form>
                                        @if(Auth::user()->is_admin)
                                        <form action="{{route('deleteDataProduct', $product)}}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-danger mt-2" type="submit">Hapus</button>
                                        </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection