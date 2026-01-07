<div class="absolute inset-x-0 bottom-0 z-50 max-w-2xl">
    @if (session()->has('success'))
        <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
            class="bg-green-500 text-white px-4 py-2 rounded">
            {{ session('success') }}
        </div>
    @endif
</div>
