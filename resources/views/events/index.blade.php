<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Events') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @forelse ($events as $event)
                <div class="bg-white shadow-md rounded-lg mb-6 p-6">
                    <h3 class="font-bold text-xl">{{ $event->program_name }}</h3>
                    <p class="text-gray-600">{{ $event->club_name }}</p>
                </div>
            @empty
                <p class="text-gray-600">No events found.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
