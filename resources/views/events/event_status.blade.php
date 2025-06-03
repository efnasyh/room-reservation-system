<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Event Status') }}
        </h2>
    </x-slot>

    <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
        <h3 class="text-2xl font-bold text-gray-800 tracking-wide">
            🗃️ Events Status
        </h3>
    </div>

    <!-- Session Messages with visible borders -->
    @if (session('message'))
        <div class="bg-green-100 border-2 border-green-600 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 border-2 border-red-600 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @foreach ($events as $event)
                <div class="bg-white shadow-md rounded-lg mb-6 p-6 relative border border-gray-300">
                    <!-- Delete Button with confirmation -->
                    <form action="{{ route('events.destroy', $event->id) }}" method="POST" class="absolute top-4 left-4 delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="bg-red-600 text-white font-bold py-1 px-3 rounded hover:bg-red-800 delete-button">
                            Delete Event ✖
                        </button>
                    </form>

                    <div class="flex items-center justify-between mt-8">
                        <!-- Event Details -->
                        <div>
                            <h3 class="font-bold text-xl">{{ $event->program_name }}</h3>
                            <p><strong>Applicant Name:</strong> {{ $event->applicant_name }}</p>
                            <p><strong>Matric No:</strong> {{ $event->matric_no }}</p>
                            <p><strong>Phone No:</strong> {{ $event->phone_no }}</p>
                            <p><strong>Advisor Name:</strong> {{ $event->advisor_name }}</p>
                            <p><strong>Location:</strong> {{ $event->location }}</p>
                            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($event->date)->format('d/m/Y') }}</p>
                            <p><strong>Allocation Requested: RM</strong> {{ $event->allocation_requested }}</p>
                            <p><strong>Participants:</strong> {{ $event->participants }}</p>
                        </div>

                        <!-- Event Status -->
                        <div class="text-right">
                            <p class="font-bold text-gray-700">Event Status:</p>
                            @if ($event->status == 'approved')
                                <p class="text-green-600 font-bold">Approved ✔</p>
                                <div class="mt-4">
                                    <p class="mt-2 text-sm text-gray-700">
                                        <strong>Total Registered Students:</strong> {{ $event->studentRegistrations->count() }}
                                    </p>
                                </div>
                            @elseif ($event->status == 'pending')
                                <p class="text-yellow-600 font-bold">Pending ⌛</p>
                            @else
                                <p class="text-red-600 font-bold">Rejected ✖</p>
                            @endif
                        </div>
                    </div>

                    <!-- Comments Section -->
                    @if ($event->comments->count() > 0)
                        <div class="mt-4">
                            <h3 class="font-semibold text-lg">Comments:</h3>
                            <ul class="list-disc pl-5">
                                @foreach ($event->comments as $comment)
                                    <li>{{ $comment->content }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @else
                        <p class="mt-4 text-gray-600">No comments available for this event.</p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Confirmation popup for delete buttons
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This event will be deleted permanently!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        // Show success popup after deletion (if message exists)
        @if(session('message'))
            Swal.fire({
                title: 'Deleted!',
                text: "{{ session('message') }}",
                icon: 'success',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
        @endif
    </script>

</x-app-layout>
