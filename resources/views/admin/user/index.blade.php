<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Users') }}
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
                        <input type="search" name="search" placeholder="search" id="search"
                               value="{{ $search ?? $search }}">
                    </p>
                    <div class="mb-4">
                        <p><input type="radio" name="sort" value="sort_id" class="mr-2" id="id"
                                  {{ ($sort == 'sort_id')? "checked" : "" }} checked><label for="id">Sort by id</label>
                        </p>
                        <p><input type="radio" name="sort" value="sort_name" class="mr-2"
                                  id="name" {{ ($sort == 'sort_name')? "checked" : "" }}><label for="name">Sort by
                                name</label></p>
                        <p><input type="radio" name="sort" value="sort_surname" class="mr-2"
                                  id="surname" {{ ($sort == 'sort_surname')? "checked" : "" }}><label for="surname">Sort
                                by surname</label></p>
                        <p><input type="radio" name="sort" value="sort_role" class="mr-2"
                                  id="role" {{ ($sort == 'sort_role')? "checked" : "" }}><label for="role">Sort by
                                role</label></p>
                    </div>
                    <button type="submit"
                            class="bg-green-600 hover:bg-green-700 p-2 transition rounded-md font-semibold text-gray-800 dark:text-gray-200 leading-tight w-full">
                        use filter
                    </button>
                </form>
            </nav>
        </div>
        <div class="p-6 bg-white dark:bg-gray-700 mt-6 mx-auto max-w-4xl rounded-md">
            <table class="border-collapse w-full">
                <thead>
                <tr class="dark:bg-cyan-900 text-center text-gray-800 dark:text-gray-200">
                    <td class="border p-3">Avatar</td>
                    <td class="border p-3">Id</td>
                    <td class="border p-3">Role</td>
                    <td class="border p-3">Name</td>
                    <td class="border p-3">Surname</td>
                    <td class="border p-3">Email</td>
                    <td class="border p-3">Status</td>
                </tr>
                </thead>
                <tbody class="text-gray-800 dark:text-gray-200">
                @foreach($users as $user)
                    <tr class="bg-gray-800">
                        <td class="border p-2 text-center"><img
                                src="{{ $user->getFirstMediaUrl('avatars') ?? public_path('img/default-avatar.webp') }}"
                                alt="Avatar" class="w-10 h-10 rounded-full object-cover mx-auto"></td>
                        <td class="border p-2 text-center">{{ $user->id }}</td>
                        <td class="border p-2">
                            @if(Auth::user()->id != $user->id)
                                <form action="{{ route('admin/users/changeRole') }}" method="post"
                                      class="flex items-center justify-center gap-x-3">
                                    @csrf
                                    <select name="role" class="w-full bg-gray-600 select_no_submit">
                                        <option value="admin" {{ ($user->role == "admin")? "selected" : "" }}>Admin
                                        </option>
                                        <option value="user" {{ ($user->role == "user")? "selected" : "" }}>User
                                        </option>
                                    </select>
                                    <input type="hidden" name="id" value="{{ $user->id }}">
                                </form>
                            @else
                                <p class="text-center">This is your account</p>
                            @endif
                        </td>
                        <td class="border p-2">{{ $user->name }}</td>
                        <td class="border p-2">{{ $user->surname }}</td>
                        <td class="border p-2">{{ $user->email }}</td>
                        <td class="border p-2">
                            @if(Auth::user()->id != $user->id)
                                <form action="{{ route('admin/users/changeStatus') }}" method="post"
                                      class="flex items-center justify-between gap-x-3">
                                    @csrf
                                    <select name="status" class="w-full bg-gray-600 select_no_submit">
                                        <option value="active" {{ ($user->status == "active")? "selected" : "" }}>
                                            active
                                        </option>
                                        <option
                                            value="read_only" {{ ($user->status == "read_only")? "selected" : "" }} >
                                            read only
                                        </option>
                                        <option value="ban" {{ ($user->status == "ban")? "selected" : "" }}>ban</option>
                                    </select>
                                    <input type="hidden" name="id" value="{{ $user->id }}">
                                </form>
                            @else
                                <p class="text-center">This is your account</p>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="mt-5">
                {{ $users->withQueryString()->links('vendor.pagination.tailwind') }}
            </div>
        </div>
    </x-slot>
</x-app-layout>
