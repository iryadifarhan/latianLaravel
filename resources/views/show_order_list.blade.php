@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    Order
                </div>
                <div class="card-body">
                    <div class="row w-50 mx-auto">
                        @foreach($orders as $order)
                            <div class="card my-2">
                                <div class="card-body px-0">
                                    <p>Pelaku Pembelian: {{$order->user()->first()->name}}</p>
                                    <p>Id Pemesanan: {{$order->id}}</p>
                                    <p>Tanggal pemesanan: {{$order->created_at}}</p>
                                    <p>Status Pembayaran: <b>{{$status = ($order->is_paid == 0) ? 'Belum lunas' : 'Lunas'}}</b></p>
                                    
                                    <a href="{{route('showDetailOrder', $order)}}"><button class="btn btn-primary">Cek detail pemesanan</button></a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection