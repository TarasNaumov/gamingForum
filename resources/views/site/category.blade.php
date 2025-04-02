<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Categories') }}
        </h2>
    </x-slot>

    <x-slot name="slot">
        <div class="p-6 bg-white dark:bg-gray-700 absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 max-w-xl rounded-md flex flex-wrap">
            @foreach($categories as $category)
                <a href="{{ route('site/category/subcategories', $category->id) }}" class="block w-1/2">
                    <div class="category">
                        <div class="category_title bg-gray-800 border">
                            <h3 class="text-[#bd932a]">{{ $category->title }}</h3>
                            <div class="handle">
                                <span></span>
                                <span></span>
                            </div>
                        </div>
                        <div class="category_description bg-yellow-500 w-full p-3"><p>{{ $category->description }}</p></div>
                    </div>
                </a>
            @endforeach
        </div>
    </x-slot>
</x-app-layout>
