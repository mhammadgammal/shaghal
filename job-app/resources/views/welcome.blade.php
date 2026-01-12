<x-main-layout title="Shaghalny - find your dream job">
    <div x-data="{ show: false }" x-init="setTimeout(() => { show = true; }, 300)" class="">
        <div class="inline-flex items-center mb-2" x-show="show" x-transition:enter="transition ease-out duration-1000"
            x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100">

            <!-- Shaghal branding text -->
            <p
                class="text-gray-400 dark:text-gray-500 text-sm font-medium mb-4 rounded-full bg-white/10 px-3 py-1 w-fit">
                Shaghalni</p>

            <!-- Main headline -->
            <h1 class="text-5xl sm:text-6xl lg:text-7xl font-extrabold text-center">
                <span class="text-gray-900 dark:text-white">Find your</span> <br />
                <span class="text-gray-400 dark:text-gray-500 ml-2 font-serif italic">Dream Job</span>
            </h1>
        </div>
    </div>

    <div x-data="{ show: false }" x-init="setTimeout(() => { show = true; }, 300)" class="">
        <div class="inline-flex items-center mb-2" x-show="show" x-transition:enter="transition ease-out duration-1000"
            x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100">
            <p class="text-white/60 text-lg">Your gateway to exciting career opportunities. Explore, apply, and land
                your dream job with Shaghalni.</p>
        </div>
    </div>

    <div x-data="{ show: false }" x-init="setTimeout(() => { show = true; }, 300)" class="mb-5">
        <div class="inline-flex items-center mb-2" x-show="show" x-transition:enter="transition ease-out duration-1000"
            x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100">
            <a href="{{ route('register') }}" class="rounded-lg bg-white/10 text-white text-lg px-4 py-2">Create An
                Account</a>
            <a href="{{ route('login') }}"
                class="rounded-lg bg-gradient-to-r from-blue-500 to-purple-600 text-white text-lg px-4 py-2 ms-4">Login</a>
        </div>
    </div>
</x-main-layout>
