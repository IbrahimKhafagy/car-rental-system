@extends('layouts.app')

@section('title', 'Book a Car')

@section('content')
<h1>Book a Car</h1>
<form method="POST" action="{{ route('orders.store') }}">
    @csrf
    <input type="hidden" name="car_id" value="{{ $car->id }}">
    <div class="mb-3">
        <label for="start-date" class="form-label">Start Date</label>
        <input type="date" id="start-date" name="start_date" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="end-date" class="form-label">End Date</label>
        <input type="date" id="end-date" name="end_date" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Book</button>
</form>
@endsection
