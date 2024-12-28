<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('car')->where('user_id', auth()->id())->get();
        return view('orders.index', compact('orders'));
    }

    public function create(Car $car)
    {
        return view('orders.create', compact('car'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date|before:end_date',
            'end_date' => 'required|date|after:start_date',
        ]);


        Order::create([
            'user_id' => 1,
            'car_id' => $validated['car_id'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'total_price' => $this->calculateTotalPrice($validated['car_id'], $validated['start_date'], $validated['end_date']),
            'payment_status' => 'unpaid',
        ]);

        return redirect()->route('orders.index')->with('success', 'Order created successfully!');
    }

    private function calculateTotalPrice($carId, $startDate, $endDate)
    {
        $car = Car::findOrFail($carId);
        $days = (strtotime($endDate) - strtotime($startDate)) / 86400;
        $totalPrice = $days * $car->price_per_day;

        if ($days > 7) {
            $totalPrice *= 0.9;
        }

        return $totalPrice;
    }
}
