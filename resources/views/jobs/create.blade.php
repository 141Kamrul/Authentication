<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Create Job
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                <form method="POST" action="{{ url('/jobs') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
                        <input
                            type="text"
                            name="title"
                            class="w-full border rounded p-2 dark:bg-gray-700 dark:text-white"
                            placeholder="Job title"
                            value="{{ old('title') }}"
                            required
                        >
                    </div>

                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">Salary</label>
                        <input
                            type="number"
                            name="salary"
                            class="w-full border rounded p-2 dark:bg-gray-700 dark:text-white"
                            placeholder="Salary"
                            value="{{ old('salary') }}"
                            required
                        >
                    </div>

                    <button
                        type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Save
                    </button>
                </form>

                @if ($errors->any())
                    <ul class="mt-4 text-red-500 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

