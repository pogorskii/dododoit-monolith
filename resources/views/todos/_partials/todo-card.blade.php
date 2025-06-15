<div class="border">
    <div class="flex">
        <form action="{{route('todos.toggle-status', $todo)}}" method="POST" class="w-full">
            @csrf
            @method('PATCH')
            <button
                    class="w-full p-3 {{$todo->is_completed ? 'bg-green-700' : 'bg-gray-700'}}"
                    type="submit"
            >
                <div>
                    {{$todo->id}}
                    <h3>{{$todo->title}}</h3>
                    <p>{{$todo->description}}</p>
                </div>
            </button>
        </form>
        <button
                class="bg-gray-800 text-white rounded-md p-2"
                type="button"
                onclick="window.location.href='{{route('todos.edit', $todo)}}'"
        >
            Edit
        </button>
        <form
                action="{{route('todos.destroy', $todo)}}"
                method="POST"
                class="p-2"
        >
            @csrf
            @method('DELETE')
            <button
                    class="bg-gray-800 text-white rounded-md p-2"
            >
                Delete
            </button>
        </form>
    </div>
</div>
