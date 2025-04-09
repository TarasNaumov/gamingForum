<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    public function index(Request $request, int $id = 0)
    {
        $categoryId = $id;
        $query = Subcategory::select('id', 'title', 'description');
        $subcategories = Subcategory::search($query, $categoryId, $request);

        return view('site.subcategories', compact('subcategories', 'categoryId'));
    }
}
