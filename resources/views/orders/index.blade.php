@extends('layouts.app')

@section('title', 'Your Orders')

@section('content')
<h1>Your Orders</h1>
@if ($orders->isEmpty())
    <p>No orders found.</p>
@else
<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Car</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Total Price</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($orders as $order)
        <tr>
            <td>{{ $order->id }}</td>
            <td>{{ $order->car->name }}</td>
            <td>{{ $order->start_date }}</td>
            <td>{{ $order->end_date }}</td>
            <td>${{ $order->total_price }}</td>
            <td>{{ ucfirst($order->payment_status) }}</td>
            <td>
                @if ($order->payment_status === 'unpaid')
                <form method="POST" action="{{ route('orders.markAsPaid', $order->id) }}">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-success btn-sm">Mark as Paid</button>
                </form>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif
@endsection
