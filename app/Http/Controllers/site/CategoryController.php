<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use illuminate\Pagination\LengthAwarePaginator;

class CategoryController extends Controller
{
    public function index(Request $request) {
        $search = $request->search;
        if ($search != null) {
            $categories = Category::select("id", "title", "description")->where("title", "like", "%" . $search . "%")->orWhere("description", "like", "%" . $search . "%")->paginate(8);
        } else {
            $categories = Category::select("id", "title", "description")->paginate(8);
        }
        return view('site.category', compact('categories'));
    }
}
