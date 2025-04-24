<x-app-layout>
    <x-slot name="header">
        <div class="flex gap-x-3">
            <div><img src="{{ $topic->user->getFirstMediaUrl('avatars') }}" class="rounded-[50%] box-content w-14 h-14">
            </div>
            <div>
                <h1 class="text-gray-300 mb-1">{{ $topic->title }}</h1>
                <p class="text-gray-500">{{ $topic->description }}</p>
            </div>
        </div>
    </x-slot>
    <x-slot name="slot">
        <div class="relative bg-gray-800 w-1/2 mx-auto p-4">
            <div class="flex flex-col gap-3 overflow-y-auto h-[58vh] pr-2">
                @forelse($messages as $message)
                    <div class="topic bg-gray-600 relative border">
                        <div class="topic_setting_button absolute z-10 top-3 right-3 cursor-pointer">
                            <img src="{{ asset('img/setting-svg.svg') }}" alt="" class="w-8">
                        </div>
                        <div class="topic_setting py-2 rounded-[5px] border flex flex-col absolute z-10 top-14 right-3 bg-gray-800">
                            <a href="{{ route('site/chat/edit', $topic->id) }}" class="block w-full px-6 py-1 text-gray-300 hover:bg-gray-700">Update</a>
                            <form action="{{ route('site/message/delete', $message->id) }}" method="post">
                                @csrf
                                @method('delete')
                                <input type="hidden" name="topic_id" value="{{ $topic->id }}">
                                <button class="block w-full px-6 py-1 text-gray-300 hover:bg-gray-700">delete</button>
                            </form>
                        </div>
                        <div class="p-4 bg-gray-700 flex justify-between items-start">
                            <div class="flex justify-start gap-2">
                                <div>
                                    <img src="{{ $message->user->getFirstMediaUrl('avatars') }}"
                                         class="h-14 w-14 rounded-[50%]">
                                </div>
                                <div>
                                    <p class="text-gray-400">{{ $message->user->name }} {{ $message->user->surname }}</p>
                                    <p class="text-gray-500">{{ $message->user->role }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-4">
                            <p class="w-[82%] m-auto text-gray-200">{{ $message->text }}</p>
                            <p class="text-right">{{ $message->created_at }}</p>
                        </div>
                    </div>
                @empty
                @endforelse
            </div>
            <div class="py-4">
                @if(request()->is('site/topic/*/chat'))
                    <form action="{{ route('site/chat/store', $topic->id) }}" method="post"
                          class="relative w-[300px] h-[100px] m-auto">
                        @csrf
                        @method('post')
                        <textarea name="text" class="resize-none m-0 h-full w-full pr-14 rounded-[10px]"
                                  placeholder="Your message"></textarea>
                        <button type="submit"
                                class="absolute right-0 bottom-0 z-10 py-1 px-2 bg-yellow-500 hover:bg-yellow-600 rounded-br-[10px]">
                            send
                        </button>
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        <input type="hidden" name="topic_id" value="{{ $topic->id }}">
                    </form>
                @else
                    <form action="{{ route('site/chat/update', $message->id) }}" method="post" class="relative w-[300px] h-[100px] m-auto">
                        @csrf
                        @method('patch')
                        <textarea name="text" class="resize-none m-0 h-full w-full pr-14 rounded-[10px]" placeholder="Update your message"></textarea>
                        <button type="submit" class="absolute right-0 bottom-0 z-10 py-1 px-2 bg-yellow-500 hover:bg-yellow-600 rounded-br-[10px]">send</button>
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        <input type="hidden" name="topic_id" value="{{ $topic->id }}">
                    </form>
                @endif
            </div>
        </div>
    </x-slot>
</x-app-layout>
