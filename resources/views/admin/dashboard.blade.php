<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <x-slot name="slot">
        <div class="absolute top-1/3 left-1/2 transform -translate-x-1/2 bg-gray-800 p-7 border rounded-lg">
            <h1 class="bg-gradient-to-r text-yellow-600 text-4xl">Welcome to admin dashboard</h1>
        </div>
    </x-slot>
</x-app-layout>
