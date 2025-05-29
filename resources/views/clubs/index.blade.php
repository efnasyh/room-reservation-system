<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Clubs and Associations') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6">
                <h3 class="font-semibold text-lg mb-4">List of Clubs and Associations</h3>

                @if ($clubs->isEmpty())
                    <p>No clubs found.</p>
                @else
                    <table class="w-full border-collapse border border-gray-300">
                        <thead>
                            <tr>
                                <th class="border border-gray-300 px-4 py-2">No</th>
                                <th class="border border-gray-300 px-4 py-2">Club Name</th>
                                <th class="border border-gray-300 px-4 py-2">Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clubs as $index => $club)
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2">{{ $index + 1 }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $club->club_name }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $club->description }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
