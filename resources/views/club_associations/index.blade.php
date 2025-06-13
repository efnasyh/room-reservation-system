<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Clubs and Associations') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <h3 class="text-2xl font-bold text-gray-800 tracking-wide">
                🏫 Clubs & Associations
            </h3>
        </div>

        <div class="mt-6"></div>

        <div class="w-full px-6 mx-auto">

            <!-- Filter Buttons -->
            <div class="flex justify-center gap-4 mb-6 flex-wrap">
                @foreach (['All', 'Residential College', 'Association / Club', 'Uniform'] as $category)
                    <a href="{{ route('club_associations.index', ['filter' => $category]) }}">
                        <button class="px-4 py-2 {{ request('filter') == $category ? 'bg-blue-600 text-white' : 'bg-gray-200 hover:bg-gray-300' }} rounded-full">
                            {{ $category }}
                        </button>
                    </a>
                @endforeach
            </div>

            <!-- Search Bar -->
            <form method="GET" action="{{ route('club_associations.index') }}" class="flex items-center mb-4">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Search by club name"
                    class="border rounded px-3 py-2 mr-2 w-full sm:w-1/3 focus:outline-none focus:ring focus:border-blue-300">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Search 🔍
                </button>
            </form>

            <!-- Clubs Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
               @foreach ($clubs as $club)
    <div x-data="{ open: false }" class="bg-white shadow-md rounded-lg overflow-hidden">
        
        <!-- Club Image -->
        @php
            $fileName = strtolower(str_replace(' ', '_', $club->club_name)) . '.jpg';
            $imagePath = 'storage/club_association/' . $fileName;
        @endphp

        <div class="h-40 bg-gray-200 flex items-center justify-center">
            @if (file_exists(public_path($imagePath)))
                <img src="{{ asset($imagePath) }}" alt="{{ $club->club_name }} Logo" class="object-cover h-full w-full">
            @else
                <span class="text-gray-500">No Image</span>
            @endif
        </div>

        <!-- Club Info -->
        <div class="p-4">
            <h3 class="text-lg font-semibold text-gray-800">{{ $club->club_name }}</h3>
            
            <!-- Always-visible description -->
            <p class="text-sm text-gray-600 mt-2">{{ $club->description }}</p>

            <!-- Read More Button -->
            <button @click="open = !open"
                class="text-blue-500 mt-2 inline-block hover:underline focus:outline-none">
                Read More
            </button>

            <!-- Hidden: Objective & Contact -->
            <div x-show="open" x-transition class="mt-3 text-sm text-gray-700 space-y-2">
                @if ($club->objectives)
                    <p><strong>Objective:</strong> {{ $club->objectives }}</p>
                @endif
                @if ($club->contact)
                    <p><strong>Contact:</strong> {{ $club->contact}}</p>
                @endif
            </div>
        </div>
    </div>
@endforeach

            </div>

        </div>
    </div>
</x-app-layout>
