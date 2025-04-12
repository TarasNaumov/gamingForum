<x-app-layout>
    <x-slot name="header">
        <div class="relative flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Topics') }}
            </h2>
            <form action="{{ route('site/subcategories/search', $forumId) }}" method="get">
                @csrf
                @method("get")
                <p>
                    <input type="search" name="search" placeholder="search" class="h-9">
                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white h-9 px-2">search</button>
                </p>
            </form>
            <form action="{{ route('site/topic/create', $forumId) }}" method="post">
                @csrf
                <button type="submit" name="user_id" value="{{ Auth::user()->id }}" class="bg-green-500 px-4 py-2 text-gray-50 hover:bg-green-600">Create Topic</button>
            </form>
        </div>
    </x-slot>

    <x-slot name="slot">
        <div class="p-6 bg-white dark:bg-gray-700 mt-6 mx-auto max-w-xl rounded-md flex flex-wrap gap-3">
            @foreach($topics as $topic)
                    <div class="subcategory w-full">
                        <div class="category_title bg-gray-800 border w-full">
                            <a href="{{ route('site/forums', $topic->id) }}" class="block w-full post">
                                <div class="user mb-4 flex gap-x-3">
                                    <img src="{{ asset('img/default-avatar.webp') }}" alt="" class="w-12 rounded-[50%]">
                                    <div>
                                        <p class="text-gray-400">{{ $topic->user->name }} {{ $topic->user->surname ?? "" }}</p>
                                        <p class="text-gray-500">{{ $topic->user->role }}</p>
                                    </div>
                                </div>
                                <div class="pl-6">
                                    <h3 class="text-yellow-400">{{ $topic->title }}</h3>
                                    <p class="text-[#bd932a]">{{ $topic->description }}</p>
                                </div>
                            </a>
                        </div>
                    </div>
            @endforeach
        </div>
    </x-slot>
</x-app-layout>
