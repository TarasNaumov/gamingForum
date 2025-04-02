<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Models\Forum;
use Illuminate\Http\Request;

class ForumController extends Controller
{
    public function index(int $id = null)
    {
        if ($id == null) {
            $forums = Forum::select('id', 'title')->get();
        } else {
            $forums = Forum::where('subcategory_id', $id)->select('id', 'title')->get();
        }
        return view('site.forums', compact('forums'));
    }
}
