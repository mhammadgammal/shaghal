<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <x-toast-notification />

        <div class="max-w-3xl mx-auto">
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-6">User Details</h3>

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-600">User Name</label>
                        <div class="mt-1 text-gray-900">{{ $user->name }}</div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-600">User Email</label>
                        <div class="mt-1 text-gray-900">{{ $user->email }}</div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-600">User Role</label>
                        <div class="mt-1 text-gray-900">{{ $user->role }}</div>
                    </div>

                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <label class="block text-sm font-medium text-gray-600">Change User Password</label>
                        <div class="mt-2 relative">
                            <input id="password" name="password" type="password" placeholder="" class="w-full border border-gray-300 rounded-md px-4 py-3 pr-10 focus:outline-none focus:ring-1 focus:ring-blue-500" />

                            <button type="button" id="togglePassword" class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500">
                                <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10 3C6 3 2.73 5.11 1 8.5 2.73 11.89 6 14 10 14s7.27-2.11 9-5.5C17.27 5.11 14 3 10 3zm0 9a3 3 0 1 1 0-6 3 3 0 0 1 0 6z" />
                                </svg>
                                <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 0 0-1.414 1.414l1.38 1.38A9.957 9.957 0 0 0 1 8.5C2.73 11.89 6 14 10 14c1.27 0 2.47-.2 3.56-.57l1.66 1.66a1 1 0 1 0 1.41-1.42L3.71 2.29zM10 12a3.978 3.978 0 0 0 2.83-1.17l-1.42-1.42A1.99 1.99 0 0 1 10 10a2 2 0 0 1-2-2c0-.34.08-.66.21-.94L6.6 5.66A9.97 9.97 0 0 0 1 8.5C2.73 11.89 6 14 10 14z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>

                        @error('password')
                            <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                        @enderror

                        <div class="mt-6 flex justify-end items-center space-x-4">
                            <a href="{{ route('users.index') }}" class="text-gray-500 hover:text-gray-700">Cancel</a>
                            <button type="submit" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-md">Update User Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        (function () {
            const toggle = document.getElementById('togglePassword');
            const pwd = document.getElementById('password');
            const eyeOpen = document.getElementById('eyeOpen');
            const eyeClosed = document.getElementById('eyeClosed');

            if (toggle) {
                toggle.addEventListener('click', function () {
                    if (pwd.type === 'password') {
                        pwd.type = 'text';
                        eyeOpen.classList.add('hidden');
                        eyeClosed.classList.remove('hidden');
                    } else {
                        pwd.type = 'password';
                        eyeOpen.classList.remove('hidden');
                        eyeClosed.classList.add('hidden');
                    }
                });
            }
        })();
    </script>
</x-app-layout>
