@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header ps-4">
                    Detail Order ID {{$order->id, $count=1}}
                </div>
                <div class="card-body px-5 py-4">
                    <h3>Perincian Biaya</h3>
                    @foreach($transactions as $transaction)
                        <div class="d-flex align-items-center mb-3">
                            <p class="form-label m-0 pe-3">{{$count}}. {{$transaction->product()->get()[0]->name}} => {{$transaction->product()->get()[0]->price}} x {{$transaction->amount}} = <b>{{$transaction->product()->get()[0]->price * $transaction->amount ,$count+=1}}</b></p>
                            <a href="{{route('showDetailProduct', [$transaction->product()->first(), '1'])}}"><button class="btn btn-warning">Cek laman detail produk</button></a>
                        </div>
                    @endforeach
                    <hr>
                    <p>Total harga barang = <b>{{$total_price}}</b></p>
                    <br>
                    <p>Total biaya admin = <b>2500</b></p>
                    <p>Total biaya pajak ppn = <b>{{$total_price * 10 / 100}}</b> </p>
                    <hr>
                    <h5><b>Total akhir: Rp.{{$price_final = $total_price + ($total_price * 10 / 100) + 2500}},-</b></h5>
                
                    <hr>
                    @if($order->payment_receipt == null && Auth::user()->is_admin == 0)
                        <h3 class="mt-4 mb-3">Pembayaran</h3>
                        <form action="{{route('submitPayment',$order)}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <label for="receipt" class='form-label'>Bukti Pembayaran</label><br>
                            <input type="file" class="form-control mb-3" name="receipt" id="receipt">
                            <label for="nominal" class='form-label'>Jumlah Uang Yang Dibayar</label><br>
                            <input type="number" class='form-control' name="nominal" id="nominal" placeholder="nominal"><br>
                            <input type="hidden" name="price_final" value='{{$price_final}}'>
                            <button type="submit" class="btn btn-success">Proses Pembayaran</button>
                            @if($errors->any())
                                @foreach($errors->all() as $error)
                                    <p><b>{{$error}}</b></p>
                                @endforeach
                            @endif
                        </form>
                        <a href="{{route('showOrderList')}}"><button class="btn btn-info mt-2">Kembali</button></a>
                    @elseif(Auth::user()->is_admin == 0)
                        <h3>Bukti Pembayaran</h3>
                        <p>Foto Receipt Pembayaran: <a href="{{Storage::url('order_receipts/'.$order->payment_receipt)}}">Bukti Receipt</a></p>
                        <p>Status Pembayaran: <b>{{$status_pembayaran = ($order->is_paid == 1) ? 'Sudah terverifikasi' : 'Belum terverifikasi'}}</b></p>
                        <a href="{{route('showOrderList')}}"><button class="btn btn-info mt-2">Kembali</button></a>
                    @else
                        <a href="{{route('showOrderConfirmation')}}"><button class="btn btn-info mt-2">Kembali</button></a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection