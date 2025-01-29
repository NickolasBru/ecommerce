<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Categories::all());
    }
}
