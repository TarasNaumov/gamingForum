<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubcategoryStorePostRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Subcategory;

class SubcategoryController extends Controller
{
    /**
     * Display a list of subcategories with optional search and sorting.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $sort = $request->get('sort');

        $subcategories = Subcategory::getSubcategory($sort, $search);
        return view('admin.subcategory.subcategory', compact('subcategories', 'search', 'sort'));
    }

    /**
     * Show the form to create a new subcategory.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $categories = Category::select('id', 'title')->get();
        return view('admin.subcategory.create', compact('categories'));
    }

    /**
     * Store a new subcategory in the database.
     *
     * @param SubcategoryStorePostRequest $request
     * @return RedirectResponse
     */
    public function store(SubcategoryStorePostRequest $request)
    {
        Subcategory::create($request->validated());
        return to_route('admin/subcategory');
    }

    /**
     * Show the form to edit an existing subcategory.
     *
     * @param Subcategory $subcategory
     * @return \Illuminate\View\View
     */
    public function edit(Subcategory $subcategory)
    {
        $categories = Category::select('id', 'title')->get();
        return view('admin.subcategory.edit', compact('subcategory', 'categories'));
    }

    /**
     * Update an existing subcategory in the database.
     *
     * @param Subcategory $subcategory
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Subcategory $subcategory, Request $request)
    {
        $data = [
            'title' => $request->post('title'),
            'description' => $request->post('description'),
            'category_id' => $request->post('category_id'),
        ];
        $subcategory->update($data);
        return to_route('admin/subcategory');
    }

    /**
     * Delete a subcategory by its ID.
     *
     * @param int $id Subcategory ID
     * @return RedirectResponse
     */
    public function delete(int $id)
    {
        Subcategory::findOrFail($id)->delete();
        return back();
    }

    /**
     * Restore a soft-deleted subcategory.
     *
     * @param int $id Subcategory ID
     * @return RedirectResponse
     */
    public function restore(int $id)
    {
        Subcategory::onlyTrashed()->findOrFail($id)->restore();
        return back();
    }
}
