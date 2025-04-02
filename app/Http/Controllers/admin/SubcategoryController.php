<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Subcategory;

class SubcategoryController extends Controller
{
    public function index() {
        $subcategories = Subcategory::withTrashed()->select("id", "category_id", "title", "description", "deleted_at")->get();
        return view("admin.subcategory.subcategory", compact("subcategories"));
    }

    public function create()
    {
        $categories = Category::select("id", "title")->get();
        return view("admin.subcategory.create", compact("categories"));
    }

    public function store(Request $request)
    {
        $data = [
            "title" => $request->post("title"),
            "description" => $request->post("description"),
            "category_id" => $request->post("category_id")
        ];
        Subcategory::store($data);

        return to_route("admin/subcategory");
    }

    public function edit($subcategory)
    {
        $subcategory = Subcategory::where('id', $subcategory->id)->first();;
        $categories = Category::select("id", "title")->get();

        return view("admin.subcategory.edit", compact("subcategory", "categories"));
    }

    public function update(Subcategory $subcategory, Request $request)
    {
        $data = [
            "title" => $request->post("title"),
            "description" => $request->post("description"),
            "category_id" => $request->post("category_id"),
        ];
        $subcategory->update($data);
        return to_route("admin/subcategory");
    }

    public function delete(int $id)
    {
        Subcategory::findOrFail($id)->delete();
        return back();
    }

    public function restore(int $id)
    {
        Subcategory::onlyTrashed()->findOrFail($id)->restore();
        return back();
    }
}
