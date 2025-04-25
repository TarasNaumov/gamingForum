<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Display a list of categories with optional search functionality.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request)
    {
        $search = $request->search;

        if ($search != null) {
            // Search categories by title or description
            $categories = Category::select("id", "title", "description")
                ->where("title", "like", "%" . $search . "%")
                ->orWhere("description", "like", "%" . $search . "%")
                ->paginate(8);
        } else {
            // Display all categories
            $categories = Category::select("id", "title", "description")->paginate(8);
        }

        return view('site.category', compact('categories'));
    }
}
