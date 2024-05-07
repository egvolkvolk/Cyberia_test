<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilterRequest;
use App\Http\Services\FilterService;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductController extends Controller
{
    /**
     * @param FilterRequest $request
     * @param FilterService $filterService
     * @return LengthAwarePaginator
     */
    public function index(FilterRequest $request, FilterService $filterService): LengthAwarePaginator
    {
        return $filterService->productFilter($request);
    }
}
