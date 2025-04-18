<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Http\Requests\MessageRequest;
use App\Models\Message;
use App\Models\Topic;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
//        $messages = Message::select('text, user_id')->orderBy('created_at', 'desc')->get();
        $topic = Topic::with(['messages', 'messages.media'])->findOrFail($id);
        $messages = $topic->messages;
        return view('site.messages.chat', compact('topic', 'messages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MessageRequest $request)
    {
        Message::create($request->validated());
        return to_route('site.messages.index');
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
    public function destroy($id)
    {
        Message::findOrFail($id)->delete();
        return to_route('site.messages.index');
    }
}
