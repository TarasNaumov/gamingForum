<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    public function index(Request $request, int $id = 0)
    {
        $forumId = $id;
        $query = Topic::select('id', 'title', 'description', 'like', 'user_id');
        $topics = Topic::search($query, $forumId, $request);

        return view('site.topics', compact('topics', 'forumId'));
    }
}
