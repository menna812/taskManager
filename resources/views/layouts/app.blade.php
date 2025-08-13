<!DOCTYPE html>
<html>
<head>
    <title>Task Manager</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>

<nav class="navbar navbar-light bg-light mb-4">
    <div class="container d-flex justify-content-between align-items-center">
        
        <a class="navbar-brand" href="{{ url('/') }}">Task Manager</a>
        
        @auth
            <div class="d-flex align-items-center">
                <a href="{{ route('tasks.trash') }}" class="btn btn-outline-secondary btn-sm me-2">
                    <i class="bi bi-trash"></i> Recently Deleted
                </a>
                
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </div>
        @endauth
        
    </div>
</nav>

<div class="container">
    @yield('content')
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
