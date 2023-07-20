<!-- index.blade.php -->

@extends('layouts')

@section('content')
    <h2 class="text-center mb-5">Orders Table</h2>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product Name</th>
                    <th>Currency</th>
                    <th>Amount</th>
                    <th>Invoice</th>
                    <th>Transaction ID</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr @if ($order->status== "processing") class="table table-success" @endif>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $order->product_name }}</td>
                        <td>{{ $order->currency }}</td>
                        <td>{{ $order->amount }}</td>
                        <td>{{ $order->invoice }}</td>
                        <td>{{ $order->trxID }}</td>
                        <td>{{ $order->status }}</td>
                        <td class="text-right">
                            <a href="{{route('orders.show', $order->id)}}" class="btn btn-primary">View</a>
                            
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
