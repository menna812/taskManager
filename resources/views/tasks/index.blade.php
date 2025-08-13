@extends('layouts.app')

@section('content')
<!-- Bootstrap Icons (in case your layout doesn't include them) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="m-0">Your Tasks</h2>
        <a href="{{ route('tasks.create') }}" class="btn btn-primary">Add New Task</a>
    </div>

    <!-- Status Filter -->
    <div class="row mb-3">
        <div class="col-md-4">
            <form method="GET" action="{{ route('tasks.index') }}">
                <div class="input-group">
                    <select name="status" class="form-select">
                        <option value="">All Tasks</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending Only</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed Only</option>
                    </select>
                    <button type="submit" class="btn btn-outline-secondary">
                        <i class="bi bi-funnel"></i> Filter
                    </button>
                    @if(request('status'))
                        <a href="{{ route('tasks.index') }}" class="btn btn-outline-danger">
                            <i class="bi bi-x"></i> Clear
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($tasks->isEmpty())
        <p>
            @if(request('status'))
                No {{ request('status') }} tasks found.
            @else
                You have no tasks yet.
            @endif
        </p>
    @else
        <!-- Show current filter status -->
        @if(request('status'))
            <div class="alert alert-info">
                Showing <strong>{{ request('status') }}</strong> tasks only.
            </div>
        @endif

        <div class="list-group">
            @foreach($tasks as $task)
                <div class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="me-3 flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="mb-1">{{ $task->title }}</h5>
                                <p class="mb-1">{{ $task->description }}</p>

                                @if(!empty($task->due_date))
                                    <small class="text-muted d-block">
                                        Due: {{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}
                                    </small>
                                @endif

                                <small class="text-muted d-block">
                                    Created: {{ $task->created_at->format('M d, Y H:i') }}
                                    &nbsp;|&nbsp;
                                    Updated: {{ $task->updated_at->format('M d, Y H:i') }}
                                </small>
                            </div>

                            <div class="text-end ms-3">
                                {{-- Status icons: Completed / Pending --}}
                                @if($task->is_completed)
                                    <span class="badge bg-success mb-2">
                                        <i class="bi bi-check-circle-fill"></i>&nbsp;Completed
                                    </span>
                                @else
                                    <span class="badge bg-warning text-dark mb-2">
                                        <i class="bi bi-hourglass-split"></i>&nbsp;Pending
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-column align-items-end gap-2">
                        <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>

                        <!-- Delete button: opens modal, DOES NOT submit directly -->
                        <button type="button"
                                class="btn btn-sm btn-outline-danger delete-btn"
                                data-action="{{ route('tasks.destroy', $task->id) }}"
                                title="Delete">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- Delete Confirmation Modal (one modal for all delete actions) -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- IMPORTANT: this form will have its action set by JS to the correct task destroy route -->
      <form id="deleteForm" method="POST">
        @csrf
        @method('DELETE')

        <div class="modal-body">
          Are you sure you want to delete this task?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger">Delete</button>
        </div>
      </form>

    </div>
  </div>
</div>

<!-- Ensure Bootstrap's JS is available (in case layout didn't include it) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('.delete-btn');
    const deleteModalEl = document.getElementById('deleteModal');
    const deleteForm = document.getElementById('deleteForm');

    // create bootstrap modal instance
    const bsDeleteModal = new bootstrap.Modal(deleteModalEl);

    deleteButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            const action = this.getAttribute('data-action');
            if (!action) {
                console.error('Delete button missing data-action attribute.');
                return;
            }

            // set the form action to the route for that task
            deleteForm.setAttribute('action', action);

            // show the modal
            bsDeleteModal.show();
        });
    });

    // Optional: when form is submitted, the modal will close automatically by page reload.
    // No extra JS required for submission.
});
</script>
@endsection
