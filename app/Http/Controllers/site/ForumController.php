<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Models\Forum;
use Illuminate\Http\Request;

class ForumController extends Controller
{
    public function index(Request $request, int $id = 0)
    {
        $subcategoryId = $id;
        $query = Forum::select('id', 'title');
        $forums = Forum::search($query, $id, $request);
        return view('site.forums', compact('forums', 'subcategoryId'));
    }
}
