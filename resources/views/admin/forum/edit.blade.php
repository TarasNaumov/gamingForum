<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Update Forum</h2>
    </x-slot>
    <x-slot name="slot">
        <form action="{{ route('admin/forum/update', $forum) }}" method="post" class="rounded-md p-5 mx-auto w-1/5 mt-6 bg-gradient-to-tr from-indigo-500 via-purple-500 to-pink-500">
            @csrf
            @method('patch')
            <p class="mb-4">
                <label for="title" class="block mb-1 dark:text-gray-200 font-bold">Forum Title</label>
                <input type="text" name="title" id="title" class="w-full" value="{{ $forum->title }}">
            </p>
            <p class="mb-4">
                <label for="subcategory" class="block mb-1 dark:text-gray-200 font-bold">Subcategory</label>
                <select name="subcategory_id" id="subcategory">
                    @foreach($subcategories as $subcategory)
                        <option value="{{ $subcategory->id }}" {{$subcategory->id == $forum->subcategory_id ? "selected" : "" }}>{{ $subcategory->title }}</option>
                    @endforeach
                </select>
            </p>
            @if($errors->any())
                <div class="mb-4">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            <button type="submit" class="w-full bg-green-500 hover:bg-green-600 transition p-2 rounded-md text-gray-50">{{ __('UPDATE') }}</button>
        </form>
    </x-slot>
</x-app-layout>
