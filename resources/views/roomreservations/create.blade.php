<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Upcoming Event') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
        @if(session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
            <div class="bg-white p-6 rounded-lg shadow-md">
                <form action="{{route ('roomreservations.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Room Name -->
                    <div class="form-control w-full mb-4">
                        <label class="label">
                            <span class="label-text">Room Name</span>
                        </label>
                        <input type="text" name="room_name" class="input input-bordered w-full" value="{{ $room-> name}}" readonly>
                    </div>
                    @error('room_name')
                        <div class="alert alert-error">
                            {{ $message }}
                        </div>
                    @enderror

                     <!-- Applicant Name -->
                     <div class="form-control w-full mb-4">
                        <label class="label">
                            <span class="label-text">Applicant Name</span>
                        </label>
                        <input type="text" name="user_name" class="input input-bordered w-full" value="{{ $user->name}}" readonly>
                    </div>
                    @error('user_name')
                        <div class="alert alert-error">
                            {{ $message }}
                        </div>
                    @enderror

                    <!-- Start Date -->
                    <div class="form-control w-full mb-4">
                        <label class="label">
                            <span class="label-text">Start Date</span>
                        </label>
                        <input type="date" name="start_date" class="input input-bordered w-full" value="{{old ('start_date')}}">
                    </div>
                    @error('start_date')
                        <div class="alert alert-error">
                            {{ $message }}
                        </div>
                    @enderror

                    <!-- End Date -->
                    <div class="form-control w-full mb-4">
                        <label class="label">
                            <span class="label-text">End Date</span>
                        </label>
                        <input type="date" name="end_date" class="input input-bordered w-full" value="{{old ('end_date')}}">
                    </div>
                    @error('end_date')
                        <div class="alert alert-error">
                            {{ $message }}
                        </div>
                    @enderror

                    <!-- Participant -->
                    <div class="form-control w-full mb-4">
                        <label class="label">
                            <span class="label-text">Participant</span>
                        </label>
                        <input type="number" name="participant" class="input input-bordered w-full" placeholder="Enter capacity" value="{{ old('participant') }}">
                    </div>
                    @error('participant')
                        <div class="alert alert-error">
                            {{ $message }}
                        </div>
                    @enderror

                     <!-- Purpose -->
                     <div class="form-control w-full mb-4">
                        <label class="label">
                            <span class="label-text">Purpose</span>
                        </label>
                        <textarea name="purpose" class="input input-bordered w-full" placeholder="Enter purpose">{{ old('purpose') }}</textarea>
                    </div>
                    @error('purpose')
                        <div class="alert alert-error">
                            {{ $message }}
                        </div>
                    @enderror

                    <input type="hidden" name="room_id" value="{{ $room ->id}}">
                    <input type="hidden" name="user_id" value="{{ $user ->id}}">
 
                    <!-- Submit Button -->
                    <div class="form-control mt-6">
                        <button type="submit" class="btn btn-primary">Upcoming Event</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>