<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForumStorePostRequest;
use App\Http\Requests\TopicStorePostRequest;
use App\Models\Forum;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ForumController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $sort = $request->get('sort');
        $forums = Forum::getForums($search, $sort);
//        $forums =  Forum::withTrashed()->select('id', 'title', 'subcategory_id', 'deleted_at')->get();
        $subcategories = Subcategory::select("id", "title")->get();
        return view('admin.forum.forum', compact('forums', 'subcategories', 'search', 'sort'));
    }

    public function create()
    {
        $subcategories = Subcategory::select("id", "title")->get();
        return view('admin.forum.create', compact('subcategories'));
    }

    public function store(ForumStorePostRequest $request)
    {
        Forum::create($request->validated());
        return to_route("admin/forum");
    }

    public function edit(int $id)
    {
        $forum = Forum::getById($id);
        $subcategories = Subcategory::select("id", "title")->get();
        return view('admin.forum.edit', compact('forum', 'subcategories'));
    }

    public function update(Request $request, Forum $forum)
    {
        $data = [
            'title' => $request->post('title'),
            'subcategory_id' => $request->post('subcategory_id'),
        ];
        $forum->update($data);
        return to_route("admin/forum");
    }

    public function delete(int $id)
    {
        Forum::findOrFail($id)->delete();
        return back();
    }

    public function restore(int $id)
    {
        Forum::onlyTrashed()->findOrFail($id)->restore();
        return back();
    }
}
