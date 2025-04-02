<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    public function index(int $id = null)
    {
        if ($id == null) {
            $subcategories = Subcategory::select('id', 'title', 'description')->get();
        } else {
            $subcategories = Subcategory::where('category_id', $id)->get();
        }
        return view('site.subcategories', compact('subcategories'));
    }
}
