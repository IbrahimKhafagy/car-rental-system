@extends('layouts.app')

@section('title', 'Available Cars')

@section('content')
<h1 class="mb-4">Available Cars</h1>
<div id="cars-list" class="row">
    @foreach ($cars as $car)
    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $car->name }}</h5>
                <p class="card-text">Type: {{ $car->type }}</p>
                <p class="card-text">Price per day: ${{ $car->price_per_day }}</p>
                <p class="card-text">Status: {{ $car->availability_status ? 'Available' : 'Unavailable' }}</p>
                @if ($car->availability_status)
                <a href="{{ route('orders.create', $car->id) }}" class="btn btn-primary">Book Now</a>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
