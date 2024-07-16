<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
      .split {
        height: 100%;
        width: 50%;
        position: fixed;
        z-index: 1;
        top: 0;
        overflow-x: hidden;
        padding-top: 20px;
      }
      .left {
        left: 0;
        background-color: #f1f1f1;
      }
      .right {
        right: 0;
        background-color: #ddd;
      }
      .centered {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
      }
      .center-logo {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 2;
      }
    </style>
  </head>
  <body>
    <!-- <div class="container">
      <header class="d-flex justify-content-center py-3">
        <ul class="nav nav-pills">
          <li class="nav-item"><a href="{{ route('home') }}" class="nav-link active" aria-current="page">Home</a></li>
          <li class="nav-item"><a href="{{ route('products.index') }}" class="nav-link">Products</a></li>
          @if (Route::has('login'))
            @auth
              <li class="nav-item"><a href="{{ url('/dashboard') }}" class="nav-link">Dashboard</a></li>
            @else
              <li class="nav-item"><a href="{{ route('login') }}" class="nav-link">Login</a></li>
              @if (Route::has('register'))
                <li class="nav-item"><a href="{{ route('register') }}" class="nav-link">Register</a></li>
              @endif
            @endauth
          @endif
        </ul>
      </header>
    </div> -->

    <div class="split left">
      <div class="centered">
        <h2><a href="{{ route('products.index') }}">Visiteur</a></h2>
      </div>
    </div>

    <div class="center-logo">
  <a href="{{ route('home') }}">
  <img src="{{ asset('image/eco-service.png') }}" alt="Logo" style="max-width: 400px; max-height: 400px;">
  </a>
</div>



    <div class="split right">
      <div class="centered">
        <h2><a href="{{ url('/admin') }}">Administrateur</a></h2>         
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
