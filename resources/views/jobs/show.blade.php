<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Job Details
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">
                <h3 class="text-2xl font-bold mb-2">{{ $job->title }}</h3>
                <p class="text-lg mb-4">Salary: <strong>${{ number_format($job->salary) }}</strong> per year</p>

                @if($job->employer)
                    <p class="mb-4">Employer: <span class="font-semibold">{{ $job->employer->name }}</span></p>
                @endif

                

                <div class="flex space-x-4">
                    <a href="{{ url('/jobs/' . $job->id . '/edit') }}"
                       class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                        Edit
                    </a>

                    <form method="POST" action="{{ url('/jobs/' . $job->id) }}">
                        @csrf
                        @method('DELETE')
                        <button
                            type="submit"
                            class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700"
                            onclick="return confirm('Are you sure you want to delete this job?')">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
