<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index() {
        $categories = Category::select("id", "title", "description")->get();
        return view('site.category', compact('categories'));
    }
}
