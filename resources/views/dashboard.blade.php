<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('UTHM CAMPUS EVENT MANAGEMENT SYSTEM') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}

                    @php
                        $role = auth()->user()->role;
                    @endphp

                    @if ($role === 'student')
                        <div class="mt-4 p-4 bg-blue-100 rounded">
                            <h3 class="text-lg font-semibold text-blue-800">Welcome, Student!</h3>
                            <p class="text-blue-700">You can now explore events, register, and provide feedback.</p>
                        </div>
                    @elseif ($role === 'user')
                        <div class="mt-4 p-4 bg-green-100 rounded">
                            <h3 class="text-lg font-semibold text-green-800">Welcome, Organizer!</h3>
                            <p class="text-green-700">You can now create events, manage participants, and review feedback.</p>
                        </div>
                    @elseif ($role === 'mpp')
                        <div class="mt-4 p-4 bg-purple-100 rounded">
                            <h3 class="text-lg font-semibold text-purple-800">Welcome, MPP!</h3>
                            <p class="text-purple-700">You can now oversee applications, approve events, and manage student requests.</p>
                        </div>
                    @elseif ($role === 'admin')
                        <div class="mt-4 p-4 bg-yellow-100 rounded">
                            <h3 class="text-lg font-semibold text-yellow-800">Welcome, HEP!</h3>
                            <p class="text-yellow-700">You can now supervise campus-wide activities and handle compliance matters.</p>
                        </div>
                    @else
                        <div class="mt-4 p-4 bg-red-100 rounded">
                            <h3 class="text-lg font-semibold text-red-800">Unknown Role</h3>
                            <p class="text-red-700">Please contact the administrator to resolve your account status.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
