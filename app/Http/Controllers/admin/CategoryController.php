<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryStorePostRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use function Laravel\Prompts\select;

class CategoryController extends Controller
{
    /**
     * Displays a list of all categories.
     *
     * @return View
     */
    public function index()
    {
        $categories = Category::withTrashed()->select("id", "title", "description", "deleted_at")->get();
        return view('admin.category.category', compact('categories'));
    }

    /**
     * Displays the form for creating a new category.
     *
     * @return View
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Stores a new category in the database.
     *
     * @param CategoryStorePostRequest $request
     * @return RedirectResponse
     */
    public function store(CategoryStorePostRequest $request): RedirectResponse
    {
        Category::create($request->validated());

        return to_route("admin/category");
    }

    /**
     * Displays the form for editing a category.
     *
     * @param int $id Category ID.
     * @return View
     */
    public function edit(int $id): View
    {
        $category = Category::getById($id);

        return view('admin.category.edit', compact('category'));
    }

    /**
     * Updates the category data.
     *
     * @param Request $request
     * @param Category $category Category.
     * @return RedirectResponse
     */
    public function update(Request $request, Category $category): RedirectResponse
    {
        $data = [
            'title' => $request->post('title'),
            'description' => $request->post('description'),
        ];
        $category->update($data);
        return to_route("admin/category");
    }

    /**
     * Deletes a category by its ID.
     *
     * @param int $id Category ID.
     * @return RedirectResponse
     */
    public function delete(int $id)
    {
        Category::deleteById($id);
        return back();
    }

    public function restore(int $id)
    {
        Category::onlyTrashed()->findOrFail($id)->restore();
        return back();
    }
}

