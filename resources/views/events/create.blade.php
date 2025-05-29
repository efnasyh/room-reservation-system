<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Apply an Event') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div id="selection-screen" class="bg-gradient-to-br from-white via-gray-50 to-white p-10 rounded-3xl shadow-2xl max-w-3xl mx-auto text-center border border-gray-200">
    <h3 class="text-3xl font-bold text-gray-800 mb-8">Choose Your Event Application Type</h3>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
        <!-- MPP Option -->
        <div class="group bg-white rounded-xl p-6 border hover:border-blue-600 transition duration-300 shadow hover:shadow-lg">
            <img src="{{ asset('storage/app/public/logo/mpp.jpg') }}" alt="MPP Logo"
                 class="w-24 h-24 mx-auto mb-4 rounded-full object-cover border-2 border-blue-100 group-hover:border-blue-500 transition duration-300">
            <h4 class="text-xl font-semibold text-blue-700 mb-2">Majlis Perwakilan Pelajar Application</h4>
            <p class="text-gray-600 text-sm mb-4">For events with a budget below RM5,000</p>
            <button id="mpp-button"
                    class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition duration-200 shadow">
                Select MPP
            </button>
        </div>

        <!-- Admin Option -->
        <div class="group bg-white rounded-xl p-6 border hover:border-red-600 transition duration-300 shadow hover:shadow-lg">
            <img src="{{ asset('storage/app/public/logo/hep.jpg') }}" alt="Admin Logo"
                 class="w-24 h-24 mx-auto mb-4 rounded-full object-cover border-2 border-red-100 group-hover:border-red-500 transition duration-300">
            <h4 class="text-xl font-semibold text-red-700 mb-2">Pejabat Hal Ehwal Pelajar Application</h4>
            <p class="text-gray-600 text-sm mb-4">For events with a budget RM5,000 and above</p>
            <button id="admin-button"
                    class="bg-red-600 text-white px-5 py-2 rounded-lg hover:bg-red-700 transition duration-200 shadow">
                Select HEP
            </button>
        </div>
    </div>
</div>


            <div id="apply-event-form" class="hidden bg-white p-6 rounded-lg shadow-md">
                <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="application_type" id="application-type">

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

                    <!-- Club Name -->
                    <div class="form-control w-full mb-4">
                        <label class="label"><span class="label-text">Club Name</span></label>
                        <input type="text" name="club_name" required class="input input-bordered w-full" placeholder="Enter club name" value="{{ old('club_name') }}">
                    </div>
                    @error('club_name')
                        <div class="alert alert-error">{{ $message }}</div>
                    @enderror

                    <!-- Advisor Name -->
                    <div class="form-control w-full mb-4">
                    <label class="label"><span class="label-text">Advisor Name</span></label>
                    <input type="text" name="advisor_name" required class="input input-bordered w-full" placeholder="Enter advisor's name" value="{{ old('advisor_name') }}">
                    </div>
                    @error('advisor_name')
                        <div class="alert alert-error">{{ $message }}</div>
                    @enderror

                    <!-- Email -->
                    <div class="form-control w-full mb-4">
                        <label class="label"><span class="label-text">Email</span></label>
                        <input type="email" name="email" required class="input input-bordered w-full" placeholder="Enter email" value="{{ old('email') }}">
                    </div>
                    @error('email')
                        <div class="alert alert-error">{{ $message }}</div>
                    @enderror

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
</x-app-layout>
