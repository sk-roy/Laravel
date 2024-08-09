<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    
  

    <div class="container mx-auto px-4 py-8">

        @if($tasks->isEmpty())
            <p class="text-gray-600">No tasks available.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($tasks as $task)
                    <div class="bg-white p-6 rounded-lg shadow-lg border border-gray-200">
                        <h2 class="text-xl font-semibold mb-2">{{ $task->title }}</h2>
                        <p class="text-gray-700 mb-4">{{ $task->description ? $task->description : "Description: N/A" }}</p>
                        <p class="text-sm text-gray-500 mb-4">
                            Due Date: {{ $task->due_date ? $task->due_date->format('m/d/Y') : 'N/A' }}
                        </p>
                        <p class="text-sm text-gray-500 mb-4">
                            Status: <span class="{{ $task->status ? 'text-green-500' : 'text-red-500' }}">
                                {{ $task->status ? 'Completed' : 'Incomplete' }}
                            </span>
                        </p>
                        <div class="flex justify-between items-center">
                            <a href="{{ route('tasks.edit', $task->id) }}" class="bg-gray-200 text-black font-medium px-6 py-2 rounded-lg border border-gray-700 shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                Edit
                            </a>
                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-gray-200 text-black font-medium px-6 py-2 rounded-lg border border-gray-700 shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</x-app-layout>
