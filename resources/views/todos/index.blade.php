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
                    @if ($totalTodos > 0)
                        <form action="{{route('todos.toggle-status')}}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="mb-6">
                                <h2 class="text-lg font-semibold mb-2">My todos ({{$pendingTodos->count()}})</h2>
                                @foreach($pendingTodos as $todo)
                                    <div class="border">
                                        <div class="flex gap-2">
                                            <button
                                                    class="w-full p-3"
                                                    type="submit"
                                                    name="todo_id"
                                                    value="{{$todo->id}}"
                                            >
                                                <div>
                                                    <h3>{{$todo->title}}</h3>
                                                    <p>{{$todo->description}}</p>
                                                </div>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold mb-2">
                                    Completed todos ({{$completedTodos->count()}})
                                </h2>
                                @foreach($completedTodos as $todo)
                                    <div class="border">
                                        <div class="flex gap-2">
                                            <button
                                                    class="w-full p-3 bg-green-700"
                                                    type="submit"
                                                    name="todo_id"
                                                    value="{{$todo->id}}"
                                            >
                                                <div>
                                                    <h3>{{$todo->title}}</h3>
                                                    <p>{{$todo->description}}</p>
                                                </div>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </form>
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
