<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function store(StoreOrderRequest $request)
    {
        try {
            $order = $this->orderService->createOrder($request->validated());
            return new OrderResource($order);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function markAsPaid(Order $order)
    {
        try {
            if (auth()->user() && auth()->user()->role !== 'admin') {
                return response()->json(['message' => 'Unauthorized'], 403);
            }

            $updatedOrder = $this->orderService->markOrderAsPaid($order);
            return response()->json([
                'message' => 'Payment has been processed successfully.',
                'data' => new OrderResource($updatedOrder),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function index()
    {
        try {
            $orders = $this->orderService->getUserOrders(Auth::id());
            if ($orders->isEmpty()) {
                return response()->json(['message' => 'No orders found'], 404);
            }
            return OrderResource::collection($orders);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving orders.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
