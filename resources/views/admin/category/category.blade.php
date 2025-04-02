<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                <nobr>Admin Categories</nobr>
            </h2>
            <form action="{{ route('admin/category/create') }}" method="POST">
                @csrf
                <button type="submit"
                        class="bg-green-600 hover:bg-green-700 p-3 transition rounded-md font-semibold text-gray-800 dark:text-gray-200 leading-tight">{{ __('CREATE CATEGORY') }}</button>
            </form>
        </div>
    </x-slot>
    <x-slot name="slot">
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
                        <td class="border p-2">
                            <a href="{{ route('admin/category/edit', $category->id) }}" class="block w-full h-full p-2 bg-orange-700 hover:bg-orange-900 m-0 text-center">{{ __('Update') }}</a>
                        </td>

                        @if(is_null($category->deleted_at))
                            <td class="border p-2">
                                <form action="{{ route('admin/category.delete', $category->id) }}" method="POST"
                                      class="w-full h-full p-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full h-full p-2 bg-red-800 hover:bg-red-900 m-0">{{ __('Delete') }}</button>
                                </form>
                            </td>
                        @else
                            <td class="border p-2">
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
