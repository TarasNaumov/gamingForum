<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Http\Requests\TopicStorePostRequest;
use App\Models\Forum;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TopicController extends Controller
{
    /**
     * Display a list of topics for a specific forum with optional search functionality.
     *
     * @param Request $request
     * @param int $id Forum ID (default is 0)
     * @return View
     */
    public function index(Request $request, int $id = 0)
    {
        $forumId = $id;

        $query = Topic::with('user')->select('id', 'title', 'description', 'user_id');
        $topics = Topic::search($query, $forumId, $request);  // Assuming a 'search' method is implemented on the Topic model
        $forum = Forum::getById($forumId);

        return view('site.topics.topics', compact('topics', 'forumId', 'forum'));
    }

    /**
     * Show the form for creating a new topic in a specified forum.
     *
     * @param int $forumId
     * @return View
     */
    public function create($forumId)
    {
        $forums = Forum::select('id', 'title')->get();
        return view('site.topics.create', compact('forumId', 'forums'));
    }

    /**
     * Store a newly created topic in the database.
     *
     * @param TopicStorePostRequest $request
     * @param int $forumId
     * @return RedirectResponse
     */
    public function store(TopicStorePostRequest $request, $forumId)
    {
        $validated = $request->validated();
        Topic::create(array_merge($validated, ['user_id' => Auth::user()->id]));

        return to_route('site/topics', ['id' => $validated['forum_id']]);
    }

    /**
     * Show the form for editing an existing topic.
     *
     * @param int $topic_id
     * @return View
     */
    public function edit(int $topic_id)
    {
        $topic = Topic::find($topic_id);
        $forums = Forum::select("id", "title")->paginate(10);

        return view("site.topics.edit", compact("topic", "forums"));
    }

    /**
     * Update the specified topic in the database.
     *
     * @param Topic $topic
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Topic $topic, Request $request)
    {
        $data = [
            "title" => $request->post("title"),
            "description" => $request->post("description"),
            "forum_id" => $request->post("forum_id"),
        ];
        $topic->update($data);
        return to_route('site/topics', ['id' => $data['forum_id']]);
    }

    /**
     * Delete a topic from the database.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function delete(int $id)
    {
        Topic::findOrFail($id)->delete();
        return back();
    }
}
