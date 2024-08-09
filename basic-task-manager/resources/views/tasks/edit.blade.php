<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Task Edit') }}
        </h2>
    </x-slot>

    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-4 mb-4">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="max-w-2xl mx-auto px-4 py-4">
        <form action="{{ route('tasks.update', $task->id) }}" method="POST" class="bg-white p-6 rounded-lg shadow-md">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="title" class="block text-gray-700 font-medium mb-2">Title</label>
                <input type="text" id="title" name="title" value="{{ $task->title }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div class="mb-4">
                <label for="description" class="block text-gray-700 font-medium mb-2">Description</label>
                <textarea id="description" name="description" rows="4" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ $task->description }}</textarea>
            </div>

            <div class="mb-4">
                <label for="due_date" class="block text-gray-700 font-medium mb-2">Due Date</label>
                <input type="date" id="due_date" name="due_date" value="{{ $task->due_date ? $task->due_date->format('Y-m-d') : '' }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="status" class="block text-gray-700 font-medium mb-2">Status</label>
                <select id="status" name="status" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="0" {{ !$task->status ? 'selected' : '' }}>Incomplete</option>
                    <option value="1" {{ $task->status ? 'selected' : '' }}>Completed</option>
                </select>
                </select>
            </div>

            <div class="flex justify-center">
                <button type="submit" class="bg-gray-200 text-black font-medium px-6 py-2 rounded-lg border border-gray-700 shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Update
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
