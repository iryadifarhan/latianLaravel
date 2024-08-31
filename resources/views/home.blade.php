@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                    <p>Kamu login sebagai: 
                    @if($user->is_admin == 1)
                        Admin</p>
                        @if($user->check_order_exist())
                            <a href="{{route('showOrderConfirmation')}}"><button class='btn btn-info'>Konfirmasi Order</button></a>
                        @endif
                        <a href="{{route('tampilanTambahProduk')}}"><button class='btn btn-primary mx-1'>Tambah Produk</button></a>
                    @else
                        Member</p>
                        @if(isset($user->order()->get()[0]))
                            <a href="{{route('showOrderList')}}"><button class='btn btn-info'>Cek order mu</button></a>
                        @endif
                        <a href="{{route('showCartLists')}}"><button class='btn btn-primary mx-1'>Cek cart mu</button></a>
                    @endif
                    <a href="{{route('showAllProduct')}}"><button class='btn btn-primary'>Cek product yang tersedia</button></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
