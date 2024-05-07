<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeStatusRequest;
use App\Http\Requests\CreateOrderRequest;
use App\Http\Requests\OrderFilterRequest;
use App\Http\Services\FilterService;
use App\Http\Services\OrderService;
use App\Models\Order;
use Illuminate\Database\Query\Builder;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    public function index(OrderFilterRequest $request, FilterService $filterService)
    {
        return $filterService->orderFilter($request);
    }

    /**
     * @throws ValidationException
     */
    public function create(CreateOrderRequest $request, OrderService $orderService): Order
    {
        return $orderService->createOrder($request);
    }

    public function changeStatus(Order $order, ChangeStatusRequest $request, OrderService $orderService): Order
    {
        return $orderService->changeStatus($order, $request);
    }
}
