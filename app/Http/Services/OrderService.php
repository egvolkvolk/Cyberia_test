<?php
namespace App\Http\Services;

use App\Http\Requests\ChangeStatusRequest;
use App\Http\Requests\CreateOrderRequest;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;


class OrderService
{
    /**
     * @throws ValidationException
     */
    public function createOrder(CreateOrderRequest $request): Order
    {
        DB::beginTransaction();
        $order = new Order();

        $order->setStatus(Order::STATUS_NEW);
        $order->setUserId(Auth::id());

        $arrayUniqueProducts = array_count_values($request->product_ids);
        $keysArrayUniqueProducts = array_keys($arrayUniqueProducts);
        $currentSum = 0;
        for ($i = 0; $i < count($keysArrayUniqueProducts); $i++){
            $product_id = $keysArrayUniqueProducts[$i];
            $productQuantity = $arrayUniqueProducts[$product_id];

            $product = Product::where('id', $product_id)->first();

            if($productQuantity > $product->getQuantity()){
                throw ValidationException::withMessages([
                    'quantity' => ["Превышено количество продукта " . $product->getName()],
                ]);
            }
            $currentSum += (($product->getPrice()) * $productQuantity);
        }
        if($currentSum > Auth::user()['balance']){
            throw ValidationException::withMessages([
                'balance' => ["Недостаточно средств на балансе. Необходимо: " . $currentSum.". Текущий баланс: " . Auth::user()['balance']],
            ]);
        }

        Auth::user()['balance'] -= $currentSum;
        Auth::user()->save();
        $order->setSum($currentSum);
        $order->save();
        for ($i = 0; $i < count($keysArrayUniqueProducts); $i++){
            $product_id = $keysArrayUniqueProducts[$i];
            $productQuantity = $arrayUniqueProducts[$product_id];
            $product = Product::where('id', $product_id)->first();
            $product->setQuantity(($product->getQuantity()) - $productQuantity);
            $product->save();
        }
        foreach ($request->product_ids as $product_id) {
            $orderProduct = new OrderProduct();
            $orderProduct->setOrderId($order->getId());
            $orderProduct->setProductId($product_id);
            $orderProduct->save();

        }
        DB::commit();

        return $order;
    }

    /**
     * @param Order $order
     * @param ChangeStatusRequest $request
     * @return Order
     */
    public function changeStatus(Order $order, ChangeStatusRequest $request): Order
    {
        $order->setStatus($request->status);
        if($order->getStatus() === Order::STATUS_CANCELED){
            $user = User::where('id', $order->getUserId())->first();
            $user['balance'] += $order->getSum();
            $orderProductProductIds = OrderProduct::where('order_id', $order->getId())->get('product_id')->toArray();
            foreach ($orderProductProductIds as $product_id){
                $product = Product::where('id', $product_id)->first();
                $product->setQuantity(($product->GetQuantity()) + 1);
                $product->save();
            }
            $user->save();
        }
        $order->save();
        return $order;
    }

}
