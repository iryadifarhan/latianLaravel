@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-md-8 mx-auto pt-2">
            <div class="card">
                <div class="card-header">
                    Edit Product
                </div>
                <div class="card-body">
                    <form action="{{route('updateDataProduct', $product)}}" method="post">
                        @csrf
                        @method('patch')
                        <div class="mb-3">
                            <label for="name" class="form-label ps-2">Nama</label>
                            <input type="text" class="form-control" value="{{$product->name}}" name="name" id="name">
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label ps-2">Harga</label>
                            <input type="text" class="form-control" value="{{$product->price}}" name="price" id="price">
                        </div>
                        <div class="mb-3">
                            <label for="desc" class="form-label ps-2">Deskripsi</label>
                            <input type="text" class="form-control" value="{{$product->description}}" name="description" id="desc">
                        </div>
                        <div class="mb-3">
                            <label for="stock" class="form-label ps-2">Stok</label>
                            <input type="text" class="form-control" value="{{$product->stock}}" name="stock" id="stock">
                        </div>
                        <div class="mb-4">
                            <label for="image" class="form-label ps-2">Gambar</label>
                            <input type="file" class="form-control" name="image" id="image">
                        </div>

                        <button class="btn btn-success" type="submit" name="action" value="update">Update Data</button>
                    </form>
                    <form class="d-inline-block" action="{{route('deleteDataProduct', $product)}}" method="post">
                        @csrf
                        @method('delete')
                        <button class="btn btn-danger mt-2" type="submit" name="action" value="delete">Delete Data</button>
                    </form>
                    <a href="{{route('showDetailProduct',[$product, '1'])}}"><button class="btn btn-info mx-2 mt-2">Kembali</button></a>
                </div>
            </div>
        </div>
    </div>
@endsection