<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Forums') }}
        </h2>
    </x-slot>

    <x-slot name="slot">
        <div class="p-6 bg-white dark:bg-gray-700 mt-6 mx-auto max-w-xl rounded-md flex flex-wrap gap-3">
            @foreach($forums as $forum)
                <a href="" class="block w-full">
                    <div class="subcategory">
                        <div class="category_title bg-gray-800 border w-full">
                            <h3 class="text-yellow-300">{{ $forum->title }}</h3>
                            <p class="text-[#bd932a]">{{ $forum->description }}</p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </x-slot>
</x-app-layout>
