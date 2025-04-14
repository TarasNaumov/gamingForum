<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Admin Forums') }}
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
                <form action="{{ route('admin/topics/search') }}" class="mb-6">
                    <p class="mb-4 text-2xl font-bold text-center">Filter</p>
                    <p class="mb-4">
                        <label for="search" class="block">Search</label>
                        <input type="search" name="search" placeholder="search" id="search" value="{{ $search ?? $search }}">
                    </p>
                    <div class="mb-4">
                        <p><input type="radio" name="sort" value="sort_id" class="mr-2" id="id" {{ ($sort == 'sort_id')? "checked" : "" }} checked><label for="id">Sort by id</label></p>
                        <p><input type="radio" name="sort" value="sort_forum" class="mr-2" id="forum" {{ ($sort == 'sort_forum')? "checked" : "" }}><label for="forum">Sort by forum</label></p>
                        <p><input type="radio" name="sort" value="sort_title" class="mr-2" id="title" {{ ($sort == 'sort_title')? "checked" : "" }}><label for="title">Sort by title</label></p>
                        <p><input type="radio" name="sort" value="sort_description" class="mr-2" id="description" {{ ($sort == 'sort_description')? "checked" : "" }}><label for="description">Sort by description</label></p>
                        <p><input type="radio" name="sort" value="sort_delete" class="mr-2" id="description" {{ ($sort == 'sort_delete')? "checked" : "" }}><label for="description">Delete first</label></p>
                    </div>
                    <button type="submit" class="bg-green-600 hover:bg-green-700 p-2 transition rounded-md font-semibold text-gray-800 dark:text-gray-200 leading-tight w-full">use filter</button>
                </form>
                <hr class="mb-3 border-gray-950">
                <form action="{{ route('admin/topics/create') }}" method="get">
                    @csrf
                    <button type="submit" class="bg-green-600 hover:bg-green-700 p-3 transition rounded-md font-semibold text-gray-800 dark:text-gray-200 leading-tight">{{ __('CREATE TOPIC') }}</button>
                </form>
            </nav>
        </div>
        <div class="p-6 bg-white dark:bg-gray-700 mt-6 mx-auto max-w-4xl rounded-md">
            <table class="border-collapse w-full">
                <thead>
                <tr class="dark:bg-cyan-900 text-center text-gray-800 dark:text-gray-200">
                    <td class="border p-3">Id</td>
                    <td class="border p-3">Forum</td>
                    <td class="border p-3">Title</td>
                    <td class="border p-3">Description</td>
                    <td class="border p-3" colspan="2">Actions</td>
                </tr>
                </thead>
                <tbody class="text-gray-800 dark:text-gray-200">
                @foreach($topics as $topic)
                    <tr class="bg-gray-800">
                        <td class="border p-2 text-center">{{ $topic->id }}</td>
                        <td class="border p-2 text-center">
                            @foreach($forums as $forum)
                                @if ($forum->id == $topic->forum_id)
                                    {{$forum->title}}
                                @endif
                            @endforeach
                        </td>
                        <td class="border p-2">{{ $topic->title }}</td>
                        <td class="border p-2">{{ $topic->description }}</td>
                            @if(is_null($topic->deleted_at))
                                <td class="border p-2"><a href="{{ route('admin/topics/edit', $topic->id) }}" class="block w-full h-full p-2 bg-orange-700 hover:bg-orange-900 m-0 text-center">{{ __('Update') }}</a></td>
                                <td class="border p-2">
                                    <form action="{{ route('admin/topic/delete', $topic->id) }}" method="post" class="w-full h-full p-0">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="w-full h-full p-2 bg-red-800 hover:bg-red-900 m-0">{{ __('Delete') }}</button>
                                    </form>
                                </td>
                            @else
                                <td class="border p-2" colspan="2">
                                    <form action="{{ route('admin/topic/restore', $topic->id) }}" method="POST" class="w-full h-full p-0">
                                        @csrf
                                        @method('patch')
                                        <button type="submit" class="w-full h-full p-2 bg-green-700 hover:bg-green-800 m-0">{{ __('Restore') }}</button>
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
