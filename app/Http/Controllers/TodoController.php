<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\UpdateTodoRequest;
use App\Http\Resources\TodoResource;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $todos = Auth::user()->todos()->get();

        $completedTodos = [];
        $pendingTodos   = [];

        foreach ($todos as $todo) {
            if ($todo->is_completed) {
                $completedTodos[] = $todo;
            } else {
                $pendingTodos[] = $todo;
            }
        }

        return view('todos.index', [
            'completedTodos' => TodoResource::collection($completedTodos),
            'pendingTodos'   => TodoResource::collection($pendingTodos),
            'totalTodos'     => $todos->count(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('todos.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTodoRequest $request)
    {
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Todo $todo)
    {
        return view('todos.form', [
            'todo' => $todo,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Todo $todo)
    {
        return view('todos.form', [
            'todo' => $todo,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTodoRequest $request, Todo $todo)
    {
        return back();
    }

    public function toggleStatus(Request $request)
    {
        try {
            ray($request->all());
            $todo = Todo::find($request->integer('todo_id'));

            if ($todo) {
                $todo->is_completed = !$todo->is_completed;
                $todo->save();
            }

            return back();
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Todo $todo)
    {
        return back();
    }
}
