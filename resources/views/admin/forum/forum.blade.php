<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Admin Forums') }}
            </h2>
            <form action="{{ route('admin/forum/create') }}" method="POST">
                @csrf
                <button type="submit" class="bg-green-600 hover:bg-green-700 p-3 transition rounded-md font-semibold text-gray-800 dark:text-gray-200 leading-tight">{{ __('CREATE FORUM') }}</button>
            </form>
        </div>
    </x-slot>
    <x-slot name="slot">
        <div class="p-6 bg-white dark:bg-gray-700 mt-6 mx-auto max-w-4xl rounded-md">
            <table class="border-collapse w-full">
                <thead>
                <tr class="dark:bg-cyan-900 text-center text-gray-800 dark:text-gray-200">
                    <td class="border p-3">Id</td>
                    <td class="border p-3">Subcategory</td>
                    <td class="border p-3">Game Title</td>
                    <td class="border p-3" colspan="2">Actions</td>
                </tr>
                </thead>
                <tbody class="text-gray-800 dark:text-gray-200">
                @foreach($forums as $forum)
                    <tr class="bg-gray-800">
                        <td class="border p-2 text-center">{{ $forum->id }}</td>
                        <td class="border p-2 text-center">
                            @foreach($subcategories as $subcategory)
                                @if ($subcategory->id == $forum->subcategory_id)
                                    {{$subcategory->title}}
                                @endif
                            @endforeach
                        </td>
                        <td class="border p-2">{{ $forum->title }}</td>
                        <td class="border p-2"><a href="{{ route('admin/forum/edit', $forum->id) }}" class="block w-full h-full p-2 bg-orange-700 hover:bg-orange-900 m-0 text-center">{{ __('Update') }}</a></td>
                        <td class="border p-2">
                            @if(is_null($forum->deleted_at))
                                <form action="{{ route('admin/forum/delete', $forum->id) }}" method="post" class="w-full h-full p-0">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="w-full h-full p-2 bg-red-800 hover:bg-red-900 m-0">{{ __('Delete') }}</button>
                                </form>
                            @else
                                <form action="{{ route('admin/forum/restore', $forum->id) }}" method="POST" class="w-full h-full p-0">
                                    @csrf
                                    @method('patch')
                                    <button type="submit" class="w-full h-full p-2 bg-green-700 hover:bg-green-800 m-0">{{ __('Restore') }}</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </x-slot>
</x-app-layout>
