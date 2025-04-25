<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SubcategoryController extends Controller
{
    /**
     * Display a list of subcategories filtered by category ID with optional search functionality.
     *
     * @param Request $request
     * @param int $id Category ID (default is 0)
     * @return View
     */
    public function index(Request $request, int $id = 0)
    {
        $categoryId = $id;
        $query = Subcategory::select('id', 'title', 'description');
        $subcategories = Subcategory::search($query, $categoryId, $request);  // Assuming a 'search' method is implemented on the Subcategory model

        return view('site.subcategories', compact('subcategories', 'categoryId'));
    }
}
