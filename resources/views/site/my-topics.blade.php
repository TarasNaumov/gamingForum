<x-app-layout>
    <x-slot name="slot">
        <div class="p-6 bg-white dark:bg-gray-700 mt-6 mx-auto max-w-6xl rounded-md flex flex-wrap gap-3">
            <div>
                <p class="mb-1 text-xl text-gray-100">My Topics</p>
                <p class="mb-3 text-gray-400">This section displays all the discussion topics you've created. You can
                    view, edit, or delete each topic from here.</p>
            </div>
            <div class="flex flex-wrap gap-2">
                @foreach($topics as $topic)
                    <div class="topic w-[calc(50%-8px)] relative border bg-gray-800">
                        <div class="topic_setting_button absolute z-10 top-3 right-3 cursor-pointer">
                            <img src="{{ asset('img/setting-svg.svg') }}" alt="" class="w-8">
                        </div>
                        <div class="topic_setting py-2 rounded-[5px] flex flex-col absolute z-10 top-14 right-3 bg-gray-600">
                            <a href="{{ route('site/topics/edit', $topic->id) }}"
                               class="block w-full px-6 py-1 text-gray-300 hover:bg-gray-700">update</a>
                            <form action="{{ route('site/topic/delete', $topic->id) }}" method="post">
                                @csrf
                                @method('delete')
                                <button class="block w-full px-6 py-1 text-gray-300 hover:bg-gray-700">delete</button>
                            </form>
                        </div>
                        <div class="category_title bg-gray-800 w-full">
                            <a href="{{ route('site/chat', $topic->id) }}" class="block w-full post">
                                <div class="mb-2">
                                    <p class="text-gray-400">{{ $topic->forum->title }}</p>
                                </div>
                                <div>
                                    <h3 class="text-yellow-400">{{ $topic->title }}</h3>
                                    <p class="text-[#bd932a]">{{ $topic->description }}</p>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </x-slot>

</x-app-layout>
