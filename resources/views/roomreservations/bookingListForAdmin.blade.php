<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">  
            {{ __('Event Requested List') }}
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
                        {{-- @foreach ($rooms as $room) --}}
                        @foreach ($roomReservations as $index => $reservation)
                            <tr class="hover">
                                {{-- <th>{{ $loop->iteration }}</th> --}}
                                <th>{{ $roomReservations->firstItem() + $index }}</th>
                                <td>{{ $reservation->room->name }}</td>
                                <td>{{ $reservation->start_date }}</td>
                                <td>{{ $reservation->end_date }}</td>
                                <td>{{ $reservation->status }}</td>
                                <td>
                                  <form action="{{ route('roomreservations.updateStatus', $reservation->id) }}" method="POST">
                                      @csrf
                                      @method('PUT')
                                      <select name="status" onchange="this.form.submit()" class="select w-full max-w-xs"> 
                                          <option value="pending" {{ $reservation->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                          <option value="approved" {{ $reservation->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                          <option value="rejected" {{ $reservation->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                      </select>
                                  </form>
                              </td>
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