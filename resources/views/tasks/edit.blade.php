@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Task</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tasks.update', $task->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="title" class="form-label">Task Title *</label>
        <input type="text" name="title" id="title" value="{{ old('title', $task->title) }}" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea name="description" id="description" class="form-control">{{ old('description', $task->description) }}</textarea>
    </div>

    <div class="mb-3">
        <label for="due_date" class="form-label">Due Date</label>
        <input type="date" name="due_date" id="due_date" value="{{ old('due_date', $task->due_date ? $task->due_date->format('Y-m-d') : '') }}" class="form-control">
    </div>

    <!-- Add this status select input -->
    <div class="mb-3">
    <label for="is_completed" class="form-label">Status</label>
    <select name="is_completed" id="is_completed" class="form-select" required>
        <option value="0" {{ old('is_completed', $task->is_completed) == 0 ? 'selected' : '' }}>Pending</option>
        <option value="1" {{ old('is_completed', $task->is_completed) == 1 ? 'selected' : '' }}>Completed</option>
    </select>
</div>


    <button type="submit" class="btn btn-primary">Update Task</button>
</form>

</div>
@endsection
