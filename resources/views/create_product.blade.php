@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    Create Product
                </div>
                <div class="card-body p-4">
                    <form action="{{route('tambahProduk')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <label for="name" class="form-label">Nama</label>
                        <input class="form-control mb-2" id="name" name="name" type="text" placeholder="nama">
                        <label for="price" class="form-label">Harga</label>
                        <input class="form-control mb-2" id="price" name="price" type="number" placeholder="harga">
                        <label for="desc" class="form-label">Deskripsi</label>
                        <input class="form-control mb-2" id="desc" name="description" type="text" placeholder="deskripsi">
                        <label for="stock" class="form-label">Stok</label>
                        <input class="form-control mb-2" id="stock" name="stock" type="number" placeholder="stok">
                        <label for="image" class="form-label">Gambar</label>
                        <input class="form-control mb-2" id="image" name="image" type="file" placeholder="gambar">
                        <br>
                
                        <button class="btn btn-primary px-5 py-2" type="submit">Buat Produk</button>
                    </form>
                    @if($errors->any())
                        @foreach($errors->all() as $error)
                            <p>{{$error}}</p>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>    
    </div>
@endsection