<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Admin Subcategories') }}
            </h2>
            <form action="{{ route('admin/subcategory/create') }}" method="get">
                @csrf
                <button type="submit" class="bg-green-600 hover:bg-green-700 p-3 transition rounded-md font-semibold text-gray-800 dark:text-gray-200 leading-tight">{{ __('CREATE SUBCATEGORY') }}</button>
            </form>
        </div>
    </x-slot>
    <x-slot name="slot">
        <div class="p-6 bg-white dark:bg-gray-700 mt-6 mx-auto max-w-7xl rounded-md">
            <table class="border-collapse w-full">
                <thead>
                <tr class="dark:bg-cyan-900 text-center text-gray-800 dark:text-gray-200">
                    <td class="border p-3">Id</td>
                    <td class="border p-3">Category id</td>
                    <td class="border p-3">Title</td>
                    <td class="border p-3">Description</td>
                    <td class="border p-3" colspan="2">Actions</td>
                </tr>
                </thead>
                <tbody class="text-gray-800 dark:text-gray-200">
                @foreach($subcategories as $subcategory)
                    <tr class="bg-gray-800">
                        <td class="border p-2 text-center">{{ $subcategory->id }}</td>
                        <td class="border p-2 text-center">{{ $subcategory->category_id }}</td>
                        <td class="border p-2">{{ $subcategory->title }}</td>
                        <td class="border p-2">{{ $subcategory->description }}</td>
                        <td class="border p-2"><a href="{{ route('admin/subcategory/edit', $subcategory->id, $subcategory->category_id) }}" class="block w-full h-full p-2 bg-orange-700 hover:bg-orange-900 m-0 text-center">{{ __('Update') }}</a></td>
                        <td class="border p-2">
                            @if(is_null($subcategory->deleted_at))
                                <form action="{{ route('admin/subcategory.delete', $subcategory->id) }}" method="post" class="w-full h-full p-0">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="block w-full p-2 bg-red-800 hover:bg-red-900 m-0">{{ __('Delete') }}</button>
                                </form>
                            @else
                                <form action="{{ route('admin/subcategory/restore', $subcategory->id) }}" method="POST" class="w-full h-full p-0">
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
