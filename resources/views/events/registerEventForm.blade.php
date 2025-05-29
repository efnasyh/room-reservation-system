<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Event Registration: ') }} {{ $event->program_name }}
        </h2>
    </x-slot>

    <div class="py-12">
               <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" 
                     x-init="setTimeout(() => show = false, 5000)" 
                     class="fixed top-4 right-4 bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded shadow-lg">
                    <strong class="font-bold">Success!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                    <span @click="show = false" class="absolute top-0 bottom-0 right-0 px-4 py-3">
                        <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 20 20">
                            <title>Close</title>
                            <path d="M14.348 5.652a1 1 0 00-1.414 0L10 8.586 7.066 5.652a1 1 0 00-1.414 1.414L8.586 10l-2.934 2.934a1 1 0 101.414 1.414L10 11.414l2.934 2.934a1 1 0 001.414-1.414L11.414 10l2.934-2.934a1 1 0 000-1.414z"/>
                        </svg>
                    </span>
                </div>
            @endif


            @if (session('success'))
                <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-md rounded-lg mb-6 p-6">
                <h3 class="font-bold text-xl">{{ $event->program_name }}</h3>
                <p><strong>Club Name:</strong> {{ $event->club_name }}</p>
                <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($event->date)->format('d/m/Y') }}</p>
                <p><strong>Location:</strong> {{ $event->location }}</p>
                <p><strong>Fee: RM </strong> {{ $event->fee }}</p>
            </div>

            <form action="{{ route('payment.checkout') }}" method="POST">
                @csrf

                <!-- Pass event ID and fee -->
                <input type="hidden" name="event_id" value="{{ $event->id }}">
                <input type="hidden" name="amount" value="{{ $event->fee * 100 }}"> <!-- Convert RM to cents -->

                <!-- Student Info -->
                <div class="bg-white shadow-md rounded-lg mb-6 p-6">
                    <h4 class="font-semibold text-lg">Student Details</h4>

                    <div class="mt-4">
                        <x-input-label for="student_name" :value="__('Student Name')" />
                        <x-text-input id="student_name" name="student_name" type="text" class="mt-1 block w-full"
                            value="{{ old('student_name', $user->name) }}" required />
                        <x-input-error class="mt-2" :messages="$errors->get('student_name')" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="matric_no" :value="__('Matriculation Number')" />
                        <x-text-input id="matric_no" name="matric_no" type="text" class="mt-1 block w-full"
                            required />
                        <x-input-error class="mt-2" :messages="$errors->get('matric_no')" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                            value="{{ old('email', $user->email) }}" required />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="phone" :value="__('Phone Number')" />
                        <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" required />
                        <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                    </div>

                    <div class="mt-4">
                        <x-input-label :value="__('Faculty')" />
                        <div class="mt-2 space-y-2">
                            @foreach (['FKEE', 'FSKTM', 'FKMP', 'FKAAB', 'FPTP', 'FPTV'] as $faculty)
                                <label class="flex items-center">
                                    <input type="radio" name="faculty" value="{{ $faculty }}" class="form-radio text-blue-600" required>
                                    <span class="ml-2">{{ $faculty }}</span>
                                </label>
                            @endforeach
                        </div>
                        <x-input-error class="mt-2" :messages="$errors->get('faculty')" />
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Pay Using Card & Register
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
