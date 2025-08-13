<!-- this is a customized welcome page instead of the laravel default  -->
<!DOCTYPE html>
<html>
<head>
    <title>Welcome to Task Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html, body {
        height: 100%;
        margin: 0;
        }

        body {
        background: url('https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1470&q=80') no-repeat center center fixed;
        background-size: cover;
        position: relative;
        font-family: Arial, sans-serif;
        color: white;
        z-index: 1;
        position: relative;
        }
        this is to make a grey overlay on the background image 
        body::before {
        content: "";
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background-color: rgba(0, 0, 0, 0.3); /* lighter overlay */
        z-index: 0;
        }

        .title {
    position: relative;
    z-index: 2; 
    display: flex;
    justify-content: center;
    flex-direction: column;
    padding-top: 30vh;
}

.buttons {
    display: flex;
    justify-content: center;
    z-index: 2;/* so it staus on top */
    position: relative; /* so z-index works */
}

    </style>
</head>
<body class="d-flex flex-column justify-content-center align-items-center vh-100 bg-light">

    <div class="background-container">
  <div class="title">
  <h1>Welcome to Task Manager</h1>
  <div class="buttons">
  <p>
    {{-- {{ }} is Blade syntax for "print this PHP code result here" --}}
    {{-- route('login.form') finds the route named 'login.form' and returns its URL --}}
    {{-- This becomes /login automatically, but if we change the URL in web.php, all links update --}}
    <a href="{{ route('login.form') }}" class="btn btn-primary">Login</a>
    or
    <a href="{{ route('register.form') }}" class="btn btn-secondary">Sign Up</a>
  </p>
    </div>
</div>

</div>


</body>
</html>
