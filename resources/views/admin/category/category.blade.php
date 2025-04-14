<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                <nobr>Admin Categories</nobr>
            </h2>
            <div class="menu-button w-12 h-6 cursor-pointer relative">
                <span class="bg-gray-50 block w-1/2 h-[2px] absolute top-1/2 left-0 -translate-y-1/2"></span>
                <span class="bg-gray-50 block w-1/2 h-[2px] absolute top-1/2 right-0 -translate-y-1/2"></span>
            </div>
        </div>
    </x-slot>
    <x-slot name="slot">
        <div class="menu w-fit p-3 bg-gray-600 text-gray-300 absolute top-0 right-0">
            <nav>
                <form action="{{ route('admin/category/search') }}" class="mb-6">
                    <p class="mb-4 text-2xl font-bold text-center">Filter</p>
                    <p class="mb-4">
                        <label for="search" class="block">Search</label>
                        <input type="search" name="search" placeholder="search" id="search" value="{{ $search ?? $search }}">
                    </p>
                    <div class="mb-4">
                        <p><input type="radio" name="sort" value="sort_id" class="mr-2" id="id" {{ ($sort == 'sort_id')? "checked" : "" }} checked><label for="id">Sort by id</label></p>
                        <p><input type="radio" name="sort" value="sort_title" class="mr-2" id="title" {{ ($sort == 'sort_title')? "checked" : "" }}><label for="title">Sort by title</label></p>
                        <p><input type="radio" name="sort" value="sort_description" class="mr-2" id="description" {{ ($sort == 'sort_description')? "checked" : "" }}><label for="description">Sort by description</label></p>
                        <p><input type="radio" name="sort" value="sort_delete" class="mr-2" id="description" {{ ($sort == 'sort_delete')? "checked" : "" }}><label for="description">Delete first</label></p>
                    </div>
                    <button type="submit" class="bg-green-600 hover:bg-green-700 p-2 transition rounded-md font-semibold text-gray-800 dark:text-gray-200 leading-tight w-full">use filter</button>
                </form>
                <hr class="mb-3 border-gray-950">
                <form action="{{ route('admin/category/create') }}" method="GET">
                    @csrf
                    <p class="font-bold text-xl text-center mb-4">ADMIN</p>
                    <button type="submit" class="bg-green-600 hover:bg-green-700 p-3 transition rounded-md font-semibold text-gray-800 dark:text-gray-200 leading-tight w-full">{{ __('CREATE CATEGORY') }}</button>
                </form>
            </nav>
        </div>
        <div class="p-6 bg-white dark:bg-gray-700 mt-6 mx-auto max-w-5xl rounded-md">
            <table class="border-collapse w-full">
                <thead>
                <tr class="dark:bg-cyan-900 text-center text-gray-800 dark:text-gray-200">
                    <td class="border p-3">Id</td>
                    <td class="border p-3">Title</td>
                    <td class="border p-3">Description</td>
                    <td class="border p-3" colspan="2">Actions</td>
                </tr>
                </thead>
                <tbody class="text-gray-800 dark:text-gray-200">
                @foreach($categories as $category)
                    <tr class="bg-gray-800">
                        <td class="border p-2 text-center">{{ $category->id }}</td>
                        <td class="border p-2">{{ $category->title }}</td>
                        <td class="border p-2">{{ $category->description }}</td>

                        @if(is_null($category->deleted_at))
                            <td class="border p-2">
                                <a href="{{ route('admin/category/edit', $category->id) }}" class="block w-full h-full p-2 bg-orange-700 hover:bg-orange-900 m-0 text-center">{{ __('Update') }}</a>
                            </td>
                            <td class="border p-2">
                                <form action="{{ route('admin/category.delete', $category->id) }}" method="POST"
                                      class="w-full h-full p-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full h-full p-2 bg-red-800 hover:bg-red-900 m-0">{{ __('Delete') }}</button>
                                </form>
                            </td>
                        @else
                            <td class="border p-2" colspan="2">
                                <form action="{{ route('admin/category/restore', $category->id) }}" method="POST"
                                      class="w-full h-full p-0">
                                    @csrf
                                    @method('patch')
                                    <button type="submit"
                                            class="w-full h-full p-2 bg-green-700 hover:bg-green-800 m-0">{{ __('Restore') }}</button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </x-slot>
</x-app-layout>
