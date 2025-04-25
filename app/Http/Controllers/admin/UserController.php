<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a list of users with optional search and sorting.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $sort = $request->get('sort');
        $users = User::getUsers($search, $sort);
        return view('admin.user.index', compact('users', 'search', 'sort'));
    }

    /**
     * Change the status of a user.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeStatus(Request $request)
    {
        $record = User::find($request->post('id'));
        $record->status = $request->post('status');
        $record->save();

        return redirect()->route('admin/users');
    }

    /**
     * Change the role of a user.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeRole(Request $request)
    {
        $record = User::find($request->post('id'));
        $record->role = $request->post('role');
        $record->save();

        return redirect()->route('admin/users');
    }
}
