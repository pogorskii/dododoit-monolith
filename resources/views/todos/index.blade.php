<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            My Todos
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if ($todos->count())
                        @foreach($todos as $todo)
                            <div>
                                <h3>{{$todo->title}}</h3>
                                <p>{{$todo->description}}</p>
                                <input
                                        type="checkbox"
                                        {{$todo->is_completed ? 'checked' : ''}}
                                        x-data="{ isCompleted: {{ $todo->is_completed ? 'true' : 'false' }} }"
                                        x-model="isCompleted"
                                        @change="
                                                fetch('/todos/{{ $todo->id }}', {
            method: 'POST', // Or 'PUT'/'PATCH' if you're updating a resource
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name=\" csrf-token\"]').getAttribute('content')
                                                                                },
                                                                                body: JSON.stringify({
                                                                                is_completed: isCompleted,
                                                                                _method: 'PATCH' // Or 'PUT' if you
                                                                                prefer, for Laravel's method spoofing
                                                                                })
                                                                                })
                                                                                .then(response => {
                                                                                if (!response.ok) {
                                                                                // Handle server errors (e.g., 400, 500)
                                                                                console.error('Server error:',
                                                                                response.statusText);
                                                                                // Optionally revert the checkbox state
                                                                                if the update failed
                                                                                isCompleted = !isCompleted;
                                                                                }
                                                                                return response.json(); // Or
                                                                                response.text() if not returning JSON
                                                                                })
                                                                                .then(data => {
                                                                                // Handle successful response (e.g.,
                                                                                show a toast notification)
                                                                                console.log('Update successful:', data);
                                                                                })
                                                                                .catch(error => {
                                                                                // Handle network errors
                                                                                console.error('Network error:', error);
                                                                                // Optionally revert the checkbox state
                                                                                if the update failed
                                                                                isCompleted = !isCompleted;
                                                                                })
                                                                                "
                                                                                >
                            </div>
                        @endforeach
                    @else
                        <div class="flex flex-col justify-center items-center grow">
                            <span class="mb-2">No todos yet.</span>
                            <a href="{{ route('todos.create') }}">
                                <button class="border px-3 py-1 font-bold bg-gray-800">Add one</button>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
