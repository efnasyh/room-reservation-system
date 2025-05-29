<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Clubs and Associations') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="w-full px-6 mx-auto">

            <!-- Filter Buttons -->
<div class="flex justify-center gap-4 mb-6 flex-wrap">
    <a href="{{ route('club_associations.index', ['filter' => 'All']) }}">
        <button class="px-4 py-2 {{ request('filter') == 'All' ? 'bg-blue-600 text-white' : 'bg-gray-200 hover:bg-gray-300' }} rounded-full">
            All
        </button>
    </a>

    <a href="{{ route('club_associations.index', ['filter' => 'Residential College']) }}">
        <button class="px-4 py-2 {{ request('filter') == 'Residential College' ? 'bg-blue-600 text-white' : 'bg-gray-200 hover:bg-gray-300' }} rounded-full">
            Residential College
        </button>
    </a>

    <a href="{{ route('club_associations.index', ['filter' => 'Association / Club']) }}">
        <button class="px-4 py-2 {{ request('filter') == 'Association / Club' ? 'bg-blue-600 text-white' : 'bg-gray-200 hover:bg-gray-300' }} rounded-full">
            Association / Club
        </button>
    </a>

    <a href="{{ route('club_associations.index', ['filter' => 'Uniform']) }}">
        <button class="px-4 py-2 {{ request('filter') == 'Uniform' ? 'bg-blue-600 text-white' : 'bg-gray-200 hover:bg-gray-300' }} rounded-full">
            Uniform
        </button>
    </a>
</div>


               <!-- Search Bar -->
                    <form method="GET" action="{{ route('club_associations.index') }}" class="flex items-center mb-4">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search by event name, date, or club"
                            class="border rounded px-3 py-2 mr-2 w-full sm:w-1/3 focus:outline-none focus:ring focus:border-blue-300">
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Search 🔍
                        </button>
                    </form>

            <!-- Clubs Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($clubs as $club)
                    <div class="bg-white shadow-md rounded-lg overflow-hidden">
                        
                        <!-- Placeholder Image -->
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

                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-800">{{ $club->club_name }}</h3>
                            <p class="text-sm text-gray-600 mt-2">{{ $club->description }}</p>
                            <a href="#" class="text-blue-500 mt-4 inline-block hover:underline">Read More</a>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</x-app-layout>
