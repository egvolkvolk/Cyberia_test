<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilterRequest;
use App\Http\Services\FilterService;
use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * @param FilterRequest $request
     * @param FilterService $filterService
     * @return LengthAwarePaginator
     */
    public function index(FilterRequest $request, FilterService $filterService): LengthAwarePaginator
    {
        return $filterService->categoryFilter($request);
    }
}
