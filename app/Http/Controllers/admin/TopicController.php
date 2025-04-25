<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TopicStorePostRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Forum;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TopicController extends Controller
{
    /**
     * Display a list of topics with optional search and sorting.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $sort = $request->get('sort');
        $topics = Topic::getTopics($search, $sort);
        $forums = Forum::select('id', 'title')->get();
        return view('admin.topic.topic', compact('topics', 'forums', 'search', 'sort'));
    }

    /**
     * Show the form to create a new topic.
     *
     * @return View
     */
    public function create()
    {
        $forums = Forum::select('id', 'title')->get();
        return view('admin.topic.create', compact('forums'));
    }

    /**
     * Store a new topic in the database.
     *
     * @param TopicStorePostRequest $request
     * @return RedirectResponse
     */
    public function store(TopicStorePostRequest $request)
    {
        Topic::create(array_merge($request->validated(), ['user_id' => Auth::user()->id]));
        return to_route('admin/topics');
    }

    /**
     * Show the form to edit an existing topic.
     *
     * @param int $topic_id Topic ID
     * @return View
     */
    public function edit(int $topic_id)
    {
        $topic = Topic::find($topic_id);
        $forums = Forum::select('id', 'title')->get();
        return view('admin.topic.edit', compact('topic', 'forums'));
    }

    /**
     * Update an existing topic in the database.
     *
     * @param Topic $topic
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Topic $topic, Request $request)
    {
        $data = [
            'title' => $request->post('title'),
            'description' => $request->post('description'),
            'forum_id' => $request->post('forum_id'),
        ];
        $topic->update($data);
        return to_route('admin/topics');
    }

    /**
     * Delete a topic by its ID.
     *
     * @param int $id Topic ID
     * @return RedirectResponse
     */
    public function delete(int $id)
    {
        Topic::findOrFail($id)->delete();
        return back();
    }

    /**
     * Restore a soft-deleted topic.
     *
     * @param int $id Topic ID
     * @return RedirectResponse
     */
    public function restore(int $id)
    {
        Topic::onlyTrashed()->findOrFail($id)->restore();
        return back();
    }
}
