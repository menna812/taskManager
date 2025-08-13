<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center" style="height: 100vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body p-5">
                        <h3 class="mb-4 text-center">Create an Account</h3>

                        {{-- Show Validation Errors --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input 
                                  type="text" 
                                  name="name" 
                                  class="form-control form-control-lg" 
                                  placeholder="Your full name" 
                                  required
                                  value="{{ old('name') }}"
                                >
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input 
                                  type="email" 
                                  name="email" 
                                  class="form-control form-control-lg" 
                                  placeholder="name@example.com" 
                                  required
                                  value="{{ old('email') }}"
                                >
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input 
                                  type="password" 
                                  name="password" 
                                  class="form-control form-control-lg" 
                                  placeholder="Enter password" 
                                  required
                                >
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Confirm Password</label>
                                <input 
                                  type="password" 
                                  name="password_confirmation" 
                                  class="form-control form-control-lg" 
                                  placeholder="Confirm password" 
                                  required
                                >
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg rounded-3">Sign Up</button>
                            </div>
                        </form>

                        <p class="mt-4 text-center text-muted">
                            Already have an account? 
                            <a href="{{ route('login.form') }}" class="text-decoration-none">Login here</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
