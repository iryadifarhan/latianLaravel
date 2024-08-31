@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    Verify Order
                </div>
                <div class="card-body">
                    @foreach($orders as $order)
                        <div class="card w-50 mx-auto mb-4">
                            <div class="card-body">
                                <p>Order ID: {{$order->id}}</p>
                                <p>Order Buyer ID: {{$order->user()->first()->id}}</p>
                                <p>Order Buyer Name: {{$order->user()->first()->name}}</p>
                                <p>Status: <b>{{$status = ($order->is_paid) ? 'Paid' : 'Unpaid'}}</b></p>
                        
                                @if($order->payment_receipt != null)
                                    <p>Payment Receipt: <a href="{{Storage::url('order_receipts/' . $order->payment_receipt)}}">Click here</a></p>
                                @else
                                    <p>Payment Receipt: Not Submitted</p>
                                @endif
                                <a href="{{route('showDetailOrder',$order)}}"><button type="button" class="btn btn-primary">Cek detail order</button></a>
                                @if($order->is_paid == 0 && $order->payment_receipt != null)
                                    <form action="{{route('confirmOrder', $order)}}" method="post">
                                        @csrf
                                        <button type="submit" class="btn btn-success mt-2">Verify Payment</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection