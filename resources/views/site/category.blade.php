<x-app-layout>
    <x-slot name="header">
        <div class="relative">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Categories') }}
            </h2>
            <form action="{{ route('site/category/search') }}" method="get" class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
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
        <div class="p-5 bg-white dark:bg-gray-700 absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 max-w-xl rounded-md">
            <div class="categories flex flex-col flex-wrap">
                @foreach($categories as $category)
                    <a href="{{ route('site/subcategories', $category->id) }}" class="block w-1/2">
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
            <div>
                {{ $categories->withQueryString()->links('vendor.pagination.simple-tailwind') }}
            </div>
        </div>
    </x-slot>
</x-app-layout>
