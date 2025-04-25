<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForumStorePostRequest;
use App\Models\Forum;
use App\Models\Subcategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ForumController extends Controller
{
    /**
     * Display a list of forums with optional search and sorting.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $sort = $request->get('sort');
        $forums = Forum::getForums($search, $sort);
        $subcategories = Subcategory::select('id', 'title')->get();

        return view('admin.forum.forum', compact('forums', 'subcategories', 'search', 'sort'));
    }

    /**
     * Show the form to create a new forum.
     *
     * @return View
     */
    public function create()
    {
        $subcategories = Subcategory::select('id', 'title')->get();
        return view('admin.forum.create', compact('subcategories'));
    }

    /**
     * Store a new forum in the database.
     *
     * @param ForumStorePostRequest $request
     * @return RedirectResponse
     */
    public function store(ForumStorePostRequest $request)
    {
        Forum::create($request->validated());
        return to_route('admin/forum');
    }

    /**
     * Show the form to edit an existing forum.
     *
     * @param int $id Forum ID
     * @return View
     */
    public function edit(int $id)
    {
        $forum = Forum::getById($id);
        $subcategories = Subcategory::select('id', 'title')->get();
        return view('admin.forum.edit', compact('forum', 'subcategories'));
    }

    /**
     * Update an existing forum in the database.
     *
     * @param Request $request
     * @param Forum $forum
     * @return RedirectResponse
     */
    public function update(Request $request, Forum $forum)
    {
        $data = [
            'title' => $request->post('title'),
            'subcategory_id' => $request->post('subcategory_id'),
        ];
        $forum->update($data);
        return to_route('admin/forum');
    }

    /**
     * Delete the forum by its ID.
     *
     * @param int $id Forum ID
     * @return RedirectResponse
     */
    public function delete(int $id)
    {
        Forum::findOrFail($id)->delete();
        return back();
    }

    /**
     * Restore a soft-deleted forum.
     *
     * @param int $id Forum ID
     * @return RedirectResponse
     */
    public function restore(int $id)
    {
        Forum::onlyTrashed()->findOrFail($id)->restore();
        return back();
    }
}
