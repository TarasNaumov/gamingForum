<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Update Forum</h2>
    </x-slot>
    <x-slot name="slot">
        <form action="{{ route('site/topics/update', $topic) }}" method="post" class="rounded-md p-5 mx-auto w-1/5 mt-6 bg-gradient-to-tr from-indigo-500 via-purple-500 to-pink-500">
            @csrf
            @method('patch')
            <p class="mb-4">
                <label for="title" class="block mb-1 dark:text-gray-200 font-bold">Topic Title</label>
                <input type="text" name="title" id="title" class="w-full" value="{{ $topic->title }}">
            </p>
            <p class="mb-4">
                <label for="description" class="block mb-1 dark:text-gray-200 font-bold">Topic Description</label>
                <input type="text" name="description" id="description" class="w-full" value="{{ $topic->description }}">
            </p>
            <p class="mb-4">
                <label for="forums" class="block mb-1 dark:text-gray-200 font-bold">Forums</label>
                <select name="forum_id" id="forums" class="w-full">
                    @foreach($forums as $forum)
                        <option value="{{ $forum->id }}" {{$forum->id == $topic->forum_id ? "selected" : "" }}>{{ $forum->title }}</option>
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
