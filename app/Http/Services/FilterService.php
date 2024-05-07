<?php
namespace App\Http\Services;

use App\Http\Requests\FilterRequest;
use App\Http\Requests\OrderFilterRequest;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\Role;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;


class FilterService
{
    public function productFilter(FilterRequest $request): LengthAwarePaginator
    {

        $query = Product::query();

        if(isset($request['category_id']))
        {
            $query->where('category_id', $request['category_id']);
        };
        if(isset($request['name']))
        {
            $query->where('name', 'like', "%{$request['name']}%");
        };
        if(isset($request['price']))
        {
            $query->where('price', $request['price']);
        };
        if(isset($request['sort']))
        {
            if(isset($request['sort']) && isset($request['order']))
            {
                $query->orderBy($request['sort'], $request['order']);
            };

            $query->orderBy($request['sort'], 'asc');
        }
        return $query->paginate($request->getLimit(), ['*'], 'page', $request->getPage());
    }

    public function categoryFilter(FilterRequest $request): LengthAwarePaginator
    {

        $query = Category::query();
        return $query->paginate($request->getLimit(), ['*'], 'page', $request->getPage());
    }

    public function orderFilter(OrderFilterRequest $request)
    {
        $query = Order::Query()->with('products');
        if(isset($request['product_id'])) {
            $order_product = OrderProduct::all()->toArray();
            $currentOrderId = -1;
            $requestIds = array();
            foreach ($order_product as $element){
                if(($element['product_id'] ===  intval($request['product_id'])) && ($element['order_id'] != $currentOrderId)){
                    $requestIds[] = $element['order_id'];
                    }
            }
            $query->whereIn('id', $requestIds);
        }
        //dd( $query->get());
        if(isset($request['status'])) {
            $query->where('status', $request['status']);
        }
        if(isset($request['sum'])) {
            $query->where('sum', $request['sum']);
        }
        if(isset($request['created_at'])) {
            $query->where('created_at',  'like', "%{$request['created_at']}%");
        }
        if(isset($request['user_id'])) {
            $query->where('user_id', $request['user_id']);
        }
        if(isset($request['sort'])) {
            if(isset($request['sort']) && isset($request['order'])) {
                return $query->get()->sortByDesc($request['sort']);
            }
            return $query->get()->sortBy($request['sort']);
        }
        return $query->get();
    }
}
