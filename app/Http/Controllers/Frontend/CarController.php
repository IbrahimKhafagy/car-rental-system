<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Car;

class CarController extends Controller
{
    public function index()
    {
        $cars = Car::all(); 
        return view('cars.index', compact('cars'));
    }
}
