<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryStorePostRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Display a list of categories with optional search and sorting.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $search = $request->get('search');
        $sort = $request->get('sort');

        $categories = Category::getCategory($sort, $search);

        return view('admin.category.category', compact('categories', 'sort', 'search'));
    }

    /**
     * Show the form to create a new category.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.category.create');
    }

    /**
     * Store a new category in the database.
     *
     * @param CategoryStorePostRequest $request
     * @return RedirectResponse
     */
    public function store(CategoryStorePostRequest $request): RedirectResponse
    {
        Category::create($request->validated());

        return to_route('admin/category');
    }

    /**
     * Show the form to edit an existing category.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $category = Category::getById($id);

        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the category in the database.
     *
     * @param CategoryStorePostRequest $request
     * @param Category $category
     * @return RedirectResponse
     */
    public function update(CategoryStorePostRequest $request, Category $category): RedirectResponse
    {
        $category->update($request->only(['title', 'description']));

        return to_route('admin/category');
    }

    /**
     * Delete the category by its ID.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function delete(int $id): RedirectResponse
    {
        Category::deleteById($id);

        return back();
    }

    /**
     * Restore a soft-deleted category.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function restore(int $id): RedirectResponse
    {
        Category::onlyTrashed()->findOrFail($id)->restore();

        return back();
    }
}
