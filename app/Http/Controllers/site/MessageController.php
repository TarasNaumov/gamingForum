<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Http\Requests\MessageRequest;
use App\Models\Message;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $topic = Topic::with([
            'messages.user',
            'messages.media'
        ])->findOrFail($id);

        $messages = $topic->messages->reverse();

        return view('site.messages.chat', compact('topic', 'messages'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(MessageRequest $request)
    {
        $validated = $request->validated();
        Message::create($validated);
        return to_route('site/chat', ['id' => $validated['topic_id']]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MessageRequest $request)
    {
        Message::save($request->validated());
        return to_route('site.messages.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id, Request $request)
    {
        Message::findOrFail($id)->delete();
        return redirect()->route('site/chat', ['id' => $request->get('topic_id')]);
    }
}
