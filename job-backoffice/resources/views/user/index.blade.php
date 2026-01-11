@php
    $isArchived = request()->has('archived') && request()->input('archived') == true;
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>


    <div class="overflow-x-auto p-6">

        <x-toast-notification />

        <div class="flex justify-end mb-4">

            <div class="flex justify-between items-center">
                <div>

                    @if ($isArchived)
                        <a href="{{ route('users.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-black hover:bg-gray-800 text-white rounded-md  transition-colors">Active</a>
                    @else
                        <!-- Archive -->
                        <a href="{{ route('users.index', ['archived' => true]) }}"
                            class="inline-flex items-center px-4 py-2 bg-black hover:bg-gray-800 text-white rounded-md  transition-colors">Arichived</a>
                    @endif
                </div>
            </div>

        </div>
        <!-- job category table -->
        <table class="min-w-full divide-y divide-gray-200 rounded-lg shadow mt-4 bg-white">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Name</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Email</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Role</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600"> Actions </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr class="border-b">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800"> {{ $user->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800"> {{ $user->email }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800"> {{ $user->role }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                            @if ($isArchived)
                                <form action="{{ route('users.restore', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-success text-green-500">♻️ Restore</button>
                                </form>
                            @else
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">✍️
                                    Edit</a>
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger text-red-500">🗃️ Archive</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="text-center py-4">No job categories found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div>
            {{ $users->links() }}
        </div>
    </div>
</x-app-layout>
