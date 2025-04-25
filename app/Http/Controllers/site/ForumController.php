<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Models\Forum;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ForumController extends Controller
{
    /**
     * Display a list of forums filtered by subcategory ID with optional search functionality.
     *
     * @param Request $request
     * @param int $id Subcategory ID (default is 0)
     * @return View
     */
    public function index(Request $request, int $id = 0)
    {
        $subcategoryId = $id;
        $query = Forum::select('id', 'title');
        $forums = Forum::search($query, $id, $request);  // Assuming a 'search' method is implemented on the Forum model
        return view('site.forums', compact('forums', 'subcategoryId'));
    }
}
