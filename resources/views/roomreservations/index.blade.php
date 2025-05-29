<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="overflow-x-auto">

            @if(session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif

  <table class="table">
    <!-- head -->
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Room Name</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <!-- row 1 -->
                     <!-- kena guna plural and singular untuk tak keluarkan semua data -->
                    @foreach($roomReservations as $index => $reservation) 
                    <tr>
                        <!--<th>{{ $loop->iteration }}</th> -->
                        
                        <th>{{ $roomReservations->firstItem() + $index }}</th>
                        <td>{{ $reservation->room->name }}</td> 
                        <td>{{ $reservation->start_date }} </td>
                        <td>{{ $reservation->end_date }} </td>
                        <td>{{ $reservation->status }} </td>
                        @if(request('action')==='list')
                        
                        <td><a href="{{route ('roomreservations.edit', $reservation->id)}}"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-edit"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg></a></td>
                        @else
                        <td>
                        <form action="{{route ('roomreservations.destroy', $reservation->id)}}"method="POST" onsubmit="return confirm('Are you sure to delete this record?')">
                            @csrf
                            @method('DELETE')
                            <button><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg></button>
                        </form>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $roomReservations->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
