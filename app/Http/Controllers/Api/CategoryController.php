<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index()
    {
        return Category::with('subcategories')->where('is_active', true)->get();
    }

    public function subcategories($id)
    {
        return Subcategory::where('category_id', $id)->where('is_active', true)->get();
    }
}
