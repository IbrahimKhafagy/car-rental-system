<?php

namespace App\Services;

use App\Models\Car;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    public function createOrder(array $data)
    {
        $car = Car::findOrFail($data['car_id']);

        if (!$car->availability_status) {
            throw new \Exception('Car is not available.');
        }

        $days = (strtotime($data['end_date']) - strtotime($data['start_date'])) / 86400;
        $total_price = $days * $car->price_per_day;

        if ($days > 7) {
            $total_price *= 0.9;
        }

        $overlappingOrders = Order::where('car_id', $data['car_id'])
            ->where(function ($query) use ($data) {
                $query->whereBetween('start_date', [$data['start_date'], $data['end_date']])
                    ->orWhereBetween('end_date', [$data['start_date'], $data['end_date']]);
            })->exists();

        if ($overlappingOrders) {
            throw new \Exception('Car is already booked for the selected dates.');
        }

        return Order::create([
            'user_id' => Auth::id(),
            'car_id' => $car->id,
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'total_price' => $total_price,
            'payment_status' => 'unpaid',
        ]);
    }

    public function markOrderAsPaid(Order $order)
    {
        $order->update(['payment_status' => 'paid']);
        return $order;
    }

    public function getUserOrders($userId)
    {
        return Order::where('user_id', $userId)->get();
    }
}
