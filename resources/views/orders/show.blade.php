
@extends('layouts')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card mt-5">
            <div class="card-header">
                {{ $order->product_name }}
            </div>
            <div class="card-body">
                <h5 class="card-title">{{ $order->product_name }}</h5>
                <p class="card-text amount">{{ $order->amount }}</p>
                <p class="card-text invoice">{{ $order->invoice }}</p>
                @if($order->status == 'pending')
                    <button class="btn btn-primary" id="bKash_button">Pay with bKash</button>
                @else
                    <h4><span class="badge badge-success">Paid</span></h4>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection