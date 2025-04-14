<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Http\Requests\TopicStorePostRequest;
use App\Models\Forum;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TopicController extends Controller
{
    public function index(Request $request, int $id = 0)
    {
        $forumId = $id;

        $query = Topic::with('user')->select('id', 'title', 'description', 'user_id');
        $topics = Topic::search($query, $forumId, $request);
        $forum = Forum::getById($forumId);

        return view('site.topics.topics', compact('topics', 'forumId', 'forum'));
    }

    public function create($forumId)
    {
        $forums = Forum::select('id', 'title')->get();
        return view('site.topics.create', compact('forumId', 'forums'));
    }

    public function store(TopicStorePostRequest $request, $forumId)
    {
        $validated = $request->validated();
        Topic::create(array_merge($validated, ['user_id' => Auth::user()->id]));

        return to_route('site/topics', ['id' => $validated['forum_id']]);
    }

    public function edit(int $topic_id)
    {
        $topic = Topic::find($topic_id);
        $forums = Forum::select("id", "title")->get();

        return view("site.topics.edit", compact("topic", "forums"));
    }

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

    public function delete(int $id)
    {
        Topic::findOrFail($id)->delete();
        return back();
    }

}
