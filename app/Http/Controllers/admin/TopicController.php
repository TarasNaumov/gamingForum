<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TopicStorePostRequest;
use App\Models\Forum;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TopicController extends Controller
{
    public function index(Request $request) {
        $search = $request->get('search');
        $sort = $request->get('sort');
        $topics = Topic::getTopics($search, $sort);
        $forums = Forum::select("id", "title")->get();;
        return view("admin.topic.topic", compact("topics", 'forums', "search", "sort"));
    }

    public function create()
    {
        $forums = Forum::select("id", "title")->get();
        return view("admin.topic.create", compact("forums"));
    }

    public function store(TopicStorePostRequest $request)
    {
        Topic::create(array_merge($request->validated(), ['user_id' => Auth::user()->id]));

        return to_route("admin/topics");
    }

    public function edit(int $topic_id)
    {
        $topic = Topic::find($topic_id);
        $forums = Forum::select("id", "title")->get();

        return view("admin.topic.edit", compact("topic", "forums"));
    }

    public function update(Topic $topic, Request $request)
    {
        $data = [
            "title" => $request->post("title"),
            "description" => $request->post("description"),
            "forum_id" => $request->post("forum_id"),
        ];
        $topic->update($data);
        return to_route("admin/topics");
    }

    public function delete(int $id)
    {
        Topic::findOrFail($id)->delete();
        return back();
    }

    public function restore(int $id)
    {
        Topic::onlyTrashed()->findOrFail($id)->restore();
        return back();
    }
}
