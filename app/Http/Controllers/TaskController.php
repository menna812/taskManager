<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    // Show all tasks of logged-in user (non-deleted only) with optional status filter
    public function index(Request $request)
    {
        $query = Task::where('user_id', Auth::id());

        // Apply status filter if provided
        if ($request->has('status') && $request->status !== '') {
            if ($request->status == 'completed') {
                $query->where('is_completed', true);
            } elseif ($request->status == 'pending') {
                $query->where('is_completed', false);
            }
        }

        $tasks = $query->orderBy('created_at', 'desc')->get();

        return view('tasks.index', compact('tasks'));
    }

    // Show single task (required by resource routes)
    public function show(Task $task)
    {
        $this->authorize('view', $task);
        return view('tasks.show', compact('task'));
    }

    // Show recently deleted tasks
    public function trash()
    {
        $tasks = Task::onlyTrashed()
                     ->where('user_id', Auth::id())
                     ->orderBy('deleted_at', 'desc')
                     ->get();

        return view('tasks.trash', compact('tasks'));
    }

    // Show create form
    public function create()
    {
        return view('tasks.create');
    }

    // Store new task
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'due_date' => 'nullable|date|after_or_equal:today',
        ]);

        Task::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            // default false if not provided
            'is_completed' => $request->has('is_completed') ? (bool) $request->is_completed : false,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully!');
    }

    // Show edit form
    public function edit(Task $task)
    {
        // keep authorization if you have policies
        $this->authorize('update', $task);

        return view('tasks.edit', compact('task'));
    }

    // Update task
    public function update(Request $request, Task $task)
    {
        // ensure user can update
        $this->authorize('update', $task);

        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'due_date' => 'nullable|date|after_or_equal:today',
            // we use is_completed (0 or 1) coming from the select
            'is_completed' => 'required|in:0,1',                 
        ]);

        // Update uses the correct column name is_completed
        $task->update($request->only(['title', 'description', 'due_date', 'is_completed']));

        // Eloquent will automatically update updated_at
        return redirect()->route('tasks.index')->with('success', 'Task updated successfully!');
    }

    // Soft delete a task (move to trash)
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        $task->delete(); // This will soft delete

        return redirect()->route('tasks.index')->with('success', 'Task moved to trash successfully!');
    }

    // Restore a task from trash
    public function restore($id)
    {
        $task = Task::onlyTrashed()->where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        
        $this->authorize('update', $task);

        $task->restore();

        return redirect()->route('tasks.index')->with('success', 'Task restored successfully!');
    }

    // Permanently delete a task
    public function forceDelete($id)
    {
        $task = Task::onlyTrashed()->where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        
        $this->authorize('delete', $task);

        $task->forceDelete();

        return redirect()->route('tasks.trash')->with('success', 'Task permanently deleted!');
    }
}