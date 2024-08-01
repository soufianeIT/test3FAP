<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre Application</title>
    <!-- Inclure Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @guest
                    <div class="d-flex ms-4">
                        <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">Login</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
                        @endif
                    </div>
                    @else
                    <li class="nav-item">

                        <div class="d-flex align-items-center">
                            <span class="me-3">{{ Auth::user()->name }}</span>
                            <a href="{{ route('home') }}" class="dropdown-item">commande</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-link">{{ __('Logout') }}</button>
                            </form>
                        </div>
                    </li> 
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Inclure Bootstrap JS et Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0/js/bootstrap.min.js"></script>
    <script>
        const dropdownBtn = document.getElementById('adminDropdown');
        console.log(dropdownBtn);
    </script>
</body>
</html>
