<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserAvatarController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|max:2048',
        ]);

        $user = auth()->user();
        $user->clearMediaCollection('avatars');
        $user->addMediaFromRequest('avatar')->toMediaCollection('avatars');

        return back();
    }
}

