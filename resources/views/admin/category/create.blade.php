<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Create Category</h2>
    </x-slot>
    <x-slot name="slot">
        <form action="{{ route('admin/category/store') }}" method="post" class="rounded-md p-5 mx-auto w-1/5 mt-6 bg-gradient-to-tr from-indigo-500 via-purple-500 to-pink-500">
            @csrf
            @method('post')
            <p class="mb-4">
                <label for="title" class="block mb-1 dark:text-gray-200 font-bold">Category Title</label>
                <input type="text" name="title" id="title" class="w-full" required>
            </p>
            <p class="mb-2">
                <label for="title" class="block mb-1 dark:text-gray-200 font-bold">Category Description</label>
                <input type="text" name="description" id="title" class="w-full">
            </p>
            <div class="mb-4">
                @if($errors->any())
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                @endif
            </div>
            <button type="submit" class="w-full bg-green-500 hover:bg-green-600 transition p-2 rounded-md text-gray-50">{{ __('CREATE') }}</button>
        </form>
    </x-slot>
</x-app-layout>
