@extends('layouts.app')

@section('content')
<!-- Bootstrap Icons (in case your layout doesn't include them) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="m-0">Recently Deleted Tasks</h2>
        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Back to Tasks</a>
    </div>

    <!-- 30-day deletion notice -->
    <div class="alert alert-info">
        <i class="bi bi-info-circle"></i>
        <strong>Note:</strong> Tasks in trash will be permanently deleted after 30 days.
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($tasks->isEmpty())
        <p>No deleted tasks found.</p>
    @else
        <div class="list-group">
            @foreach($tasks as $task)
                <div class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="me-3 flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="mb-1 text-muted">{{ $task->title }}</h5>
                                <p class="mb-1 text-muted">{{ $task->description }}</p>

                                @if(!empty($task->due_date))
                                    <small class="text-muted d-block">
                                        Due: {{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}
                                    </small>
                                @endif

                                <small class="d-flex flex-column text-muted d-block">
                                    Deleted: {{ $task->deleted_at->format('M d, Y H:i') }}
                                    &nbsp;|&nbsp;
                                    Expires: {{ $task->deleted_at->addDays(30)->format('M d, Y') }}
                                </small>
                            </div>

                            <div class="text-end ms-3">
                                <span class="badge bg-danger mb-2">
                                    <i class="bi bi-trash"></i>&nbsp;Deleted
                                </span>
                                <div class="d-flex flex-row align-items-end gap-2">
                        <!-- Restore button -->
                        <form action="{{ route('tasks.restore', $task->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-sm btn-outline-success" title="Restore">
                                <i class="bi bi-arrow-clockwise"></i> Restore
                            </button>
                        </form>

                        <!-- Permanent delete button: opens modal -->
                        <button type="button"
                                class="btn btn-sm btn-outline-danger delete-btn"
                                data-action="{{ route('tasks.forceDelete', $task->id) }}"
                                title="Delete Permanently">
                            <i class="bi bi-x-circle"></i> Delete Forever
                        </button>
                    </div>
                            </div>
                        </div>
                    </div>
                    
                    
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- Permanent Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Confirm Permanent Delete</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form id="deleteForm" method="POST">
        @csrf
        @method('DELETE')

        <div class="modal-body">
          <div class="alert alert-danger">
            <i class="bi bi-exclamation-triangle"></i>
            <strong>Warning:</strong> This will permanently delete the task and cannot be undone!
          </div>
          Are you sure you want to permanently delete this task?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger">Delete Forever</button>
        </div>
      </form>

    </div>
  </div>
</div>

<!-- Ensure Bootstrap's JS is available -->
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
});
</script>
@endsection