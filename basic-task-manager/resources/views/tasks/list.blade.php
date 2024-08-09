<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Task List') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-8 flex justify-center">

        @if($tasks->isEmpty())
            <p class="text-gray-600">No tasks available.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
                    <thead class="bg-gray-100 text-gray-600 uppercase text-xs font-medium">
                        <tr>
                            <th class="py-3 px-4 border-b">Title</th>
                            <th class="py-3 px-4 border-b">Description</th>
                            <th class="py-3 px-4 border-b">Due Date</th>
                            <th class="py-3 px-4 border-b">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @foreach($tasks as $task)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-3 px-4">{{ $task->title }}</td>
                                <td class="py-3 px-4">{{ $task->description }}</td>
                                <td class="py-3 px-4">{{ $task->due_date ? $task->due_date->format('m/d/Y') : 'N/A' }}</td>
                                <td class="py-3 px-4">{{ $task->status ? 'Completed' : 'Incomplete' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-app-layout>
