<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit Job — {{ $job->title }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                <form method="POST" action="{{ url('/jobs/' . $job->id) }}" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Job Title</label>
                        <input
                            type="text"
                            name="title"
                            class="w-full border rounded-lg p-3 dark:bg-gray-700 dark:text-white"
                            placeholder="Enter job title"
                            value="{{ old('title', $job->title) }}"
                            required
                        >
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Salary ($ per year)</label>
                        <input
                            type="number"
                            name="salary"
                            class="w-full border rounded-lg p-3 dark:bg-gray-700 dark:text-white"
                            placeholder="Enter salary amount"
                            value="{{ old('salary', $job->salary) }}"
                            min="0"
                            step="1000"
                            required
                        >
                        @error('salary')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex space-x-4 pt-4">
                        <button
                            type="submit"
                            class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700">
                            Update
                        </button>

                        <a href="{{ url('/jobs/' . $job->id) }}"
                           class="bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600">
                            Cancel
                        </a>
                    </div>
                </form>

                @if ($errors->any())
                    <div class="mt-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <h3 class="text-red-800 font-medium mb-2">Please fix the following errors:</h3>
                        <ul class="list-disc list-inside text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
