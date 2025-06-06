<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Event Registration: ') }} {{ $event->program_name }}
        </h2>
    </x-slot>

    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('events.upcoming') }}"
           class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-semibold shadow-md transition duration-200 no-underline">
            ← Back
        </a>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Success Popup -->
            @if (session('success'))
                <div x-data="{ show: true }" x-show="show"
                     x-init="setTimeout(() => show = false, 4000)"
                     class="fixed top-4 right-4 z-50 bg-green-100 border border-green-400 text-green-800 px-6 py-4 rounded shadow-lg transition-opacity">
                    ✅ <strong>{{ session('success') }}</strong>
                    <button @click="show = false" class="ml-4 text-green-600 hover:text-green-800">✖</button>
                </div>
            @endif

            <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                <h3 class="text-3xl font-extrabold text-gray-900 tracking-wide mb-4">
                    📋 Fill the Registration Event Form
                </h3>
            </div>
            <div class="mt-6"></div>
            <!-- Event Summary -->
            <div class="bg-white border border-gray-300 shadow-md rounded-lg mb-6 p-6">
                <h3 class="font-bold text-xl">{{ $event->program_name }}</h3>
                <p><strong>📛 Club Name:</strong> {{ $event->club_name }}</p>
                <p><strong>📅 Date:</strong> {{ \Carbon\Carbon::parse($event->date)->format('d/m/Y') }}</p>
                <p><strong>📍 Location:</strong> {{ $event->location }}</p>
                <p><strong>💵 Fee:</strong> RM {{ $event->fee }}</p>
            </div>

            <!-- Registration Form -->
            <form action="{{ route('payment.checkout') }}" method="POST" class="bg-white border border-gray-300 shadow-md rounded-lg p-6">
                @csrf
                <input type="hidden" name="event_id" value="{{ $event->id }}">
                <input type="hidden" name="amount" value="{{ $event->fee * 100 }}"> <!-- cents -->

                <h4 class="font-semibold text-lg mb-4">🧑‍🎓 Student Details</h4>

                <div class="space-y-4">
                    <div>
                        <x-input-label for="student_name" :value="__('Student Name')" />
                        <x-text-input id="student_name" name="student_name" type="text" class="mt-1 block w-full border border-gray-300 rounded-md" value="{{ old('student_name', $user->name) }}" required />
                        <x-input-error class="mt-2" :messages="$errors->get('student_name')" />
                    </div>

                    <div>
                        <x-input-label for="matric_no" :value="__('Matriculation Number')" />
                        <x-text-input id="matric_no" name="matric_no" type="text" class="mt-1 block w-full border border-gray-300 rounded-md" required />
                        <x-input-error class="mt-2" :messages="$errors->get('matric_no')" />
                    </div>

                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full border border-gray-300 rounded-md" value="{{ old('email', $user->email) }}" required />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>

                    <div>
                        <x-input-label for="phone" :value="__('Phone Number')" />
                        <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full border border-gray-300 rounded-md" required />
                        <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                    </div>

                    <div>
                        <x-input-label :value="__('Faculty')" />
                        <div class="mt-2 space-y-2 border border-gray-300 p-3 rounded-md">
                            @foreach (['FKEE', 'FSKTM', 'FKMP', 'FKAAB', 'FPTP', 'FPTV'] as $faculty)
                                <label class="flex items-center">
                                    <input type="radio" name="faculty" value="{{ $faculty }}" class="form-radio text-blue-600" required>
                                    <span class="ml-2">{{ $faculty }}</span>
                                </label>
                            @endforeach
                        </div>
                        <x-input-error class="mt-2" :messages="$errors->get('faculty')" />
                    </div>

                    <div class="pt-4">
                        <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow-md transition">
                            💳 Pay Using Card & Register
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Alpine.js (for popups) -->
    <script src="//unpkg.com/alpinejs" defer></script>
</x-app-layout>
