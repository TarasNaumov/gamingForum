<x-app-layout>
    <x-slot name="header">
        <div>
            <h1>{{ $topic->title }}</h1>
            <p>{{ $topic->description }}</p>
        </div>
    </x-slot>
    <x-slot name="slot">
        <div>
            @forelse($messages as $message)
                <div>
                    <p>{{ $message->text }}</p>
                    <p>{{ $message->created_at }}</p>
                </div>
            @empty
            @endforelse
        </div>
        <div class="fixed left-1/2 bottom-5 -translate-x-1/2">
            <form action="{{ route('site/chat/store', $topic->id) }}" method="post">
                @csrf
                @method('post')
                <input type="text" name="text">
                <input type="hidden" name="user_id">
                <input type="hidden" name="topic_id">
                <button type="submit">send</button>
            </form>
        </div>
    </x-slot>
</x-app-layout>
