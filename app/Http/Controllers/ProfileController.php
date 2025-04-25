<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Topic;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile edit form.
     *
     * @param Request $request
     * @return View
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     *
     * @param ProfileUpdateRequest $request
     * @return RedirectResponse
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // Fill the user model with validated data
        $request->user()->fill($request->validated());

        // If email has changed, reset the verification timestamp
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        // Save the updated user model
        $request->user()->save();

        // Redirect back to the edit profile page with a success status
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Validate the user's password for deletion
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        // Get the authenticated user
        $user = $request->user();

        // Log the user out
        Auth::logout();

        // Delete the user's account from the database
        $user->delete();

        // Invalidate the session and regenerate CSRF token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to the home page
        return Redirect::to('/');
    }

    /**
     * Display the list of topics created by the authenticated user.
     *
     * @return View
     */
    public function getMyTopics(): View
    {
        // Fetch topics created by the authenticated user, along with their associated forum and user data
        $topics = Topic::with([
            'user:id,name,surname',  // Include the user's name and surname
            'forum:id,title'         // Include the forum's title
        ])
            ->where('user_id', auth()->user()->id)  // Filter topics by the current user
            ->select('id', 'title', 'description', 'user_id', 'forum_id')  // Select only necessary fields
            ->get();

        // Return the view with the user's topics
        return view('site.my-topics', compact('topics'));
    }
}
