<x-card class="mb-2 bg-teal-600 hover:shadow-md">
    <x-card-header class="-m-2 text-lg font-bold text-white border-none">
        <div class="flex items-center">
            <svg width="28" height="28" fill="currentColor" class="bi bi-file-earmark-text-fill" viewBox="0 0 16 16">
                <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zM4.5 9a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1h-7zM4 10.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 1 0-1h4a.5.5 0 0 1 0 1h-4z"/>
            </svg>
            <span class="hidden ml-2 sm:block">{{__('Orders')}}</span>
        </div>
        <div class="text-right -mt-7">{{ $orders }}</div>
    </x-card-header>
</x-card>
