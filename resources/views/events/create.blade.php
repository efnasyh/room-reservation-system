<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Apply an Event') }}
        </h2>
    </x-slot>

<div class="py-16 bg-gradient-to-br from-blue-50 via-white to-pink-50">
    <div class="max-w-4xl mx-auto px-6">
        <div id="selection-screen" class="bg-white/80 backdrop-blur-lg p-10 rounded-3xl shadow-2xl border border-gray-200 text-center">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                        <h3 class="text-2xl font-bold text-gray-800 tracking-wide">
                            📋 Choose Your Event Application Type
            </div>
            <div class="mt-6"></div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-10">
                <!-- MPP Option -->
                <div class="group bg-white rounded-2xl p-6 border hover:border-blue-500 transition-all duration-300 shadow-md hover:shadow-xl transform hover:-translate-y-1">
                    <img src="{{ asset('storage/logo/mpp.jpg') }}" alt="MPP Logo"
                         class="w-24 h-24 mx-auto mb-4 rounded-full object-cover border-4 border-blue-100 group-hover:border-blue-400 transition duration-300">
                    <h4 class="text-xl font-semibold text-blue-700 mb-2">Majlis Perwakilan Pelajar</h4>
                    <p class="text-gray-600 text-sm mb-6">For events with a budget below RM5,000</p>
                    <button id="mpp-button"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-full transition duration-200 shadow-lg hover:scale-105">
                        Select MPP
                    </button>
                </div>

                <!-- Admin Option -->
                <div class="group bg-white rounded-2xl p-6 border hover:border-red-500 transition-all duration-300 shadow-md hover:shadow-xl transform hover:-translate-y-1">
                    <img src="{{ asset('storage/logo/hep.jpg') }}" alt="HEP Logo"
                         class="w-24 h-24 mx-auto mb-4 rounded-full object-cover border-4 border-red-100 group-hover:border-red-400 transition duration-300">
                    <h4 class="text-xl font-semibold text-red-700 mb-2">Pejabat Hal Ehwal Pelajar</h4>
                    <p class="text-gray-600 text-sm mb-6">For events with a budget RM5,000 and above</p>
                    <button id="admin-button"
                        class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-full transition duration-200 shadow-lg hover:scale-105">
                        Select HEP
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

            <div id="apply-event-form" class="hidden bg-white p-6 rounded-lg shadow-md">
                <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="application_type" id="application-type">
<div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                        <h3 class="text-2xl font-bold text-gray-800 tracking-wide">
                            📝 Fill The Event Application Form
                        </h3>
</div>
                    <div class="form-control w-full mb-4">
                        <label class="label">
                            <span class="label-text">Applicant Name</span>
                        </label>
                        <input type="text" name="applicant_name" required class="input input-bordered w-full" placeholder="Enter applicant's name" value="{{ old('applicant_name') }}">
                    </div>
                    @error('applicant_name')
                        <div class="alert alert-error">{{ $message }}</div>
                    @enderror

                     <!-- Matric Number -->
                     <div class="form-control w-full mb-4">
                        <label class="label"><span class="label-text">Matric Number</span></label>
                        <input type="text" name="matric_no" required class="input input-bordered w-full" placeholder="Enter matric number" value="{{ old('matric_no') }}">
                    </div>
                    @error('matric_no')
                        <div class="alert alert-error">{{ $message }}</div>
                    @enderror

                     <!-- Position -->
                     <div class="form-control w-full mb-4">
                        <label class="label"><span class="label-text">Position</span></label>
                        <input type="text" name="position" required class="input input-bordered w-full" placeholder="Enter position" value="{{ old('position') }}">
                    </div>
                    @error('position')
                        <div class="alert alert-error">{{ $message }}</div>
                    @enderror


                    <!-- Phone Number -->
                    <div class="form-control w-full mb-4">
                        <label class="label"><span class="label-text">Phone Number</span></label>
                        <input type="text" name="phone_no" required class="input input-bordered w-full" placeholder="Enter phone number" value="{{ old('phone_no') }}">
                    </div>
                    @error('phone_no')
                        <div class="alert alert-error">{{ $message }}</div>
                    @enderror

                    <!-- Club Name (readonly) -->
                    <div class="form-control w-full mb-4">
                        <label class="label"><span class="label-text">Club Name</span></label>
                        <input type="text" name="club_name" class="input input-bordered w-full bg-gray-100 cursor-not-allowed" value="{{ auth()->user()->club_name }}" readonly>
                    </div>

                    <!-- Advisor Name -->
                    <div class="form-control w-full mb-4">
                    <label class="label"><span class="label-text">Advisor Name</span></label>
                    <input type="text" name="advisor_name" required class="input input-bordered w-full" placeholder="Enter advisor's name" value="{{ old('advisor_name') }}">
                    </div>
                    @error('advisor_name')
                        <div class="alert alert-error">{{ $message }}</div>
                    @enderror

                   <!-- Email (readonly) -->
<div class="form-control w-full mb-4">
    <label class="label"><span class="label-text">Email</span></label>
    <input type="email" name="email" class="input input-bordered w-full bg-gray-100 cursor-not-allowed" value="{{ auth()->user()->email }}" readonly>
</div>

                    <!-- Program Name -->
                    <div class="form-control w-full mb-4">
                        <label class="label"><span class="label-text">Program Name</span></label>
                        <input type="text" name="program_name" required class="input input-bordered w-full" placeholder="Enter program name" value="{{ old('program_name') }}">
                    </div>
                    @error('program_name')
                        <div class="alert alert-error">{{ $message }}</div>
                    @enderror

                    <!-- Location -->
                    <div class="form-control w-full mb-4">
                        <label class="label"><span class="label-text">Location</span></label>
                        <input type="text" name="location" required class="input input-bordered w-full" placeholder="Enter location" value="{{ old('location') }}">
                    </div>
                    @error('location')
                        <div class="alert alert-error">{{ $message }}</div>
                    @enderror

                    <!-- Date -->
                    <div class="form-control w-full mb-4">
                        <label class="label"><span class="label-text">Date</span></label>
                        <input type="date" name="date" required class="input input-bordered w-full" min="{{ now()->toDateString() }}" value="{{ old('date') }}">
                    </div>
                    @error('date')
                        <div class="alert alert-error">{{ $message }}</div>
                    @enderror

                    <!-- Number of Participants -->
                    <div class="form-control w-full mb-4">
                        <label class="label"><span class="label-text">Number of Participants</span></label>
                        <input type="number" name="participants" required class="input input-bordered w-full" placeholder="Enter number of participants" value="{{ old('participants') }}">
                    </div>
                    @error('participants')
                        <div class="alert alert-error">{{ $message }}</div>
                    @enderror

                    <!-- fee per pax -->
                    <div class="form-control w-full mb-4">
                        <label class="label"><span class="label-text">Fee Per Person (Pax) </span></label>
                        <input type="fee" name="fee" required class="input input-bordered w-full" placeholder="Enter fee per pax" value="{{ old('fee') }}">
                    </div>
                    @error('fee')
                        <div class="alert alert-error">{{ $message }}</div>
                    @enderror

                    <!-- Upload Paperwork -->
                    <div class="form-control w-full mb-4">
                        <label class="label"><span class="label-text">Upload Paperwork</span></label>
                        <input type="file" name="paperwork" required class="file-input file-input-bordered w-full">
                    </div>
                    @error('paperwork')
                        <div class="alert alert-error">{{ $message }}</div>
                    @enderror
                    
                    <!-- Hidden input for application_type -->
                     <input type="hidden" name="application_type" value="MPP">
                    <!-- Other input fields (same as your existing form) -->

                    <!-- Allocation Requested -->
                    <div class="form-control w-full mb-4">
                        <label class="label">
                            <span class="label-text">Total Allocation Requested</span>
                        </label>
                        <input type="number" name="allocation_requested" id="allocation-requested" required class="input input-bordered w-full" placeholder="Enter total allocation" value="{{ old('allocation_requested') }}">
                        <small id="budget-note" class="text-gray-500"></small>
                    </div>
                    @error('allocation_requested')
                        <div class="alert alert-error">{{ $message }}</div>
                    @enderror

                     <!-- Submit Button -->
                        <div class="form-control mt-6">
                        <button type="submit" class="btn btn-primary">Submit Application</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('mpp-button').addEventListener('click', function() {
            document.getElementById('selection-screen').classList.add('hidden');
            document.getElementById('apply-event-form').classList.remove('hidden');
            document.getElementById('application-type').value = 'MPP';
            document.getElementById('budget-note').innerText = 'Note: Budget must be below RM5000.';
            document.getElementById('allocation-requested').max = 4999;
        });

        document.getElementById('admin-button').addEventListener('click', function() {
            document.getElementById('selection-screen').classList.add('hidden');
            document.getElementById('apply-event-form').classList.remove('hidden');
            document.getElementById('application-type').value = 'Admin';
            document.getElementById('budget-note').innerText = 'Note: Budget must be RM5000 or above.';
            document.getElementById('allocation-requested').min = 5000;
        });
    </script>
    <!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if (session('success'))
<script>
    Swal.fire({
        title: 'Success!',
        text: "{{ session('success') }}",
        icon: 'success',
        confirmButtonText: 'OK',
        confirmButtonColor: '#3085d6'
    });
</script>
@endif

</x-app-layout>
