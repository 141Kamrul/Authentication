<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Jobs
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <ul class="space-y-4">
                    @foreach ($jobs as $job)
                        <li class="border-b border-gray-200 dark:border-gray-700 pb-4">
                            <a href="{{ url('/jobs/' . $job->id) }}" class="text-blue-600 hover:underline">
                                #{{ $job->id }} — {{ $job->title }}
                            </a>
                            <p class="text-gray-700 dark:text-gray-300">
                                <strong>${{ number_format($job->salary) }}</strong> per year
                            </p>
                            <p class="text-sm text-gray-500 mt-1">
                                @if($job->employer)
                                    Employer: <span class="font-medium">{{ $job->employer->name }}</span>
                                @else
                                    <span class="italic text-gray-400">No employer assigned</span>
                                @endif
                            </p>
                        </li>
                    @endforeach
                </ul>

                <div class="mt-6">
                    <a href="{{ url('/jobs/create') }}" 
                       class="inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                        + Create Job
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
