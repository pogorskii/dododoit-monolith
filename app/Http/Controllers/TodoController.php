<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\UpdateTodoRequest;
use App\Http\Resources\TodoResource;
use App\Models\Todo;
use Illuminate\Http\RedirectResponse;
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
    public function store(StoreTodoRequest $request): RedirectResponse
    {
        try {
            $todo = Todo::create([
                'title'       => $request->string('title'),
                'description' => $request->string('description'),
                'user_id'     => Auth::id(),
            ]);

            return redirect()->route('todos.index')->with('success', 'Todo created successfully');
        } catch (\Throwable $e) {
            \Log::error($e);

            return back()->withErrors([$e->getMessage()])->withInput();
        }
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
    public function update(UpdateTodoRequest $request, Todo $todo): RedirectResponse
    {
        try {
            $todo->update([
                'title'       => $request->string('title'),
                'description' => $request->string('description'),
            ]);

            return back()->with('success', 'Todo updated successfully');
        } catch (\Throwable $e) {
            \Log::error($e);

            return back()->withErrors([$e->getMessage()])->withInput();
        }
    }

    public function toggleStatus(Request $request, Todo $todo): RedirectResponse
    {
        try {
            $todo->is_completed = !$todo->is_completed;
            $todo->save();
            $status = $todo->is_completed ? 'completed' : 'pending';

            return back()->with('success', "Todo marked as {$status} successfully");
        } catch (\Throwable $th) {
            \Log::error($th);
            return back()->withErrors([$th->getMessage()])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Todo $todo): RedirectResponse
    {
        try {
            $todo->delete();

            return back()->with('success', 'Todo deleted successfully');
        } catch (\Throwable $e) {
            \Log::error($e);

            return back()->withErrors([$e->getMessage()])->withInput();
        }
    }
}
