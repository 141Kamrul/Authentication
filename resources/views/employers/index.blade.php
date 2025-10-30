<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Employers
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <ul class="space-y-2">
                        @foreach ($employers as $employer)
                            <li class="border-b border-gray-300 pb-2">
                                <a href="{{ url('/employers/' . $employer->id) }}" 
                                   class="text-blue-600 hover:underline">
                                    {{ $employer->id }} — {{ $employer->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
