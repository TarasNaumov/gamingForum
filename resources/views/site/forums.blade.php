<x-app-layout>
    <x-slot name="header">
        <div class="relative">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Forums') }}
            </h2>
            <form action="{{ route('site/forums/search', $subcategoryId) }}" method="get"
                  class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
                @csrf
                @method("get")
                <p>
                    <input type="search" name="search" placeholder="search" class="h-9">
                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white h-9 px-2">search</button>
                </p>
            </form>
        </div>
    </x-slot>

    <x-slot name="slot">
        <div class="p-6 bg-white dark:bg-gray-700 mt-6 mx-auto max-w-xl rounded-md flex flex-wrap gap-3">
            @foreach($forums as $forum)
                <a href="{{ route('site/topics', $forum->id)  }}" class="block w-full">
                    <div class="subcategory">
                        <div class="category_title bg-gray-800 border w-full">
                            <h3 class="text-yellow-300">{{ $forum->title }}</h3>
                            <p class="text-[#bd932a]">{{ $forum->description }}</p>
                        </div>
                    </div>
                </a>
            @endforeach
            <div class="mt-5">
                {{ $forums->withQueryString()->links('vendor.pagination.tailwind') }}
            </div>
        </div>
    </x-slot>
</x-app-layout>
