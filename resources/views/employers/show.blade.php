<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Employer Details
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-bold mb-4">{{ $employer->name }}</h3>
                    <p class="mb-2">This employer has the following jobs:</p>
                    <ul class="list-disc list-inside space-y-1">
                        @forelse ($jobs as $job)
                            <li>
                                <span class="font-semibold">#{{ $job->id }}</span> — 
                                {{ $job->title }} (Salary: {{ $job->salary }})
                            </li>
                        @empty
                            <li>No jobs found for this employer.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
