<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            My Todos
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <button class="bg-gray-800 text-white p-2 rounded-md w-full mb-4"
                    onclick="window.location.href='{{route('todos.create')}}'">
                Add todo
            </button>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if ($totalTodos > 0)
                        <div class="mb-6">
                            <h2 class="text-lg font-semibold mb-2">My todos ({{$pendingTodos->count()}})</h2>
                            @foreach($pendingTodos as $todo)
                                @include('todos._partials.todo-card', ['todo' => $todo])
                            @endforeach
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold mb-2">
                                Completed todos ({{$completedTodos->count()}})
                            </h2>
                            @foreach($completedTodos as $todo)
                                @include('todos._partials.todo-card', ['todo' => $todo])
                            @endforeach
                        </div>
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
