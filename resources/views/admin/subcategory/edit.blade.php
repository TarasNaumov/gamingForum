<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Update Subcategory</h2>
    </x-slot>
    <x-slot name="slot">
        <form action="{{ route('admin/subcategory/update', $subcategory) }}" method="post" class="rounded-md p-5 mx-auto w-1/5 mt-6 bg-gradient-to-tr from-indigo-500 via-purple-500 to-pink-500">
            @csrf
            @method('patch')
            <p class="mb-4">
                <label for="title" class="block mb-1 dark:text-gray-200 font-bold">Subcategory Title</label>
                <input type="text" name="title" id="title" class="w-full" value="{{ $subcategory->title }}">
            </p>
            <p class="mb-4">
                <label for="title" class="block mb-1 dark:text-gray-200 font-bold">Subcategory Description</label>
                <input type="text" name="description" id="title" class="w-full" value="{{ $subcategory->description }}">
            </p>
            <p class="mb-4">
                <label for="category" class="block mb-1 dark:text-gray-200 font-bold">Category</label>
                <select name="category_id" id="category">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{$category->id == $subcategory->category_id ? "selected" : "" }}>{{ $category->title }}</option>
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

