<?php

namespace App\Services;

use App\Models\Car;

class CarService
{
    public function getAllCars($filters)
    {
        $query = Car::query();

        if (isset($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }

        if (isset($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        if (isset($filters['min_price']) && isset($filters['max_price'])) {
            $query->whereBetween('price_per_day', [$filters['min_price'], $filters['max_price']]);
        }

        if (isset($filters['availability_status'])) {
            $query->where('availability_status', $filters['availability_status']);
        }

        return $query->get();
    }

    public function markCarAsUnavailable($id)
    {
        $car = Car::findOrFail($id);
        $car->update(['availability_status' => 'unavailable']);

        return $car;
    }

    public function createCar(array $data)
    {
        return Car::create($data);
    }
}
