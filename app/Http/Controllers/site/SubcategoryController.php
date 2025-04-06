<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    public function index(Request $request, int $id = null)
    {
        $categoryId = $id;
        $query = Subcategory::select('id', 'title', 'description');


        if ($request->filled('search')) {
            $search = '%' . $request->search . '%';
            $query->where('title', 'like', $search)
                ->orWhere('description', 'like', $search);
        }

        if ($id != null) {
            $query->where('category_id', $id);
        }

        $subcategories = $query->get();

        return view('site.subcategories', compact('subcategories', 'categoryId'));
    }
}
