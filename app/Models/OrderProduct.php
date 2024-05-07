<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int order_id
 * @property int product_id
 */
class OrderProduct extends Model
{
    /**
     * @return int
     */
    public function getOrderId(): int
    {
        return $this->order_id;
    }

    /**
     * @param int $order_id
     * @return OrderProduct
     */
    public function setOrderId(int $order_id): OrderProduct
    {
        $this->order_id = $order_id;
        return $this;
    }

    /**
     * @return int
     */
    public function getProductId(): int
    {
        return $this->product_id;
    }

    /**
     * @param int $product_id
     * @return OrderProduct
     */
    public function setProductId(int $product_id): OrderProduct
    {
        $this->product_id = $product_id;
        return $this;
    }
    use HasFactory;


}
