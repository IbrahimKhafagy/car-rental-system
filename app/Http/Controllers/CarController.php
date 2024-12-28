<?php

namespace App\Http\Controllers;

use App\Services\CarService;
use App\Http\Requests\SaveCarRequest;
use App\Http\Resources\CarResource;
use Illuminate\Http\Request;

class CarController extends Controller
{
    protected $carService;

    public function __construct(CarService $carService)
    {
        $this->carService = $carService;
    }

    public function index(Request $request)
    {
        try {
            $filters = $request->all();
            $cars = $this->carService->getAllCars($filters);

            return CarResource::collection($cars);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching cars.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function markCarAsUnavailable($id)
    {
        try {
            $car = $this->carService->markCarAsUnavailable($id);

            return new CarResource($car);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the car status.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function saveCar(SaveCarRequest $request)
    {
        try {
            $car = $this->carService->createCar($request->validated());

            return new CarResource($car);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while adding the car.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
