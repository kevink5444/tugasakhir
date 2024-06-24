<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>CV YP Sukses Makmur</title>
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
  </head>
  <body>
    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
      <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="#">CV YP Sukses Makmur</a>
      <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <input class="form-control form-control-dark w-100 rounded-0 border-0" type="text" placeholder="Search" aria-label="Search">
      <div class="navbar-nav">
        <<div class="nav-item text-nowrap">
            <a id="logout-link" class="nav-link px-3" href="{{ route('logout') }}">Sign out</a>
        
            <!-- Form untuk logout -->
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
      </div>
    </header>

    <div class="container-fluid">
      <div class="row">
        @include('partials.sidebar')
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">@yield('title')</h1>
          </div>
          @yield('content')
        </main>
      </div>
    </div>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}" ></script>
    <script src="{{ asset('js/dashboard.js') }}" ></script>
    <script>
        // Menangani klik pada link Sign out
        document.getElementById('logout-link').addEventListener('click', function(event) {
            event.preventDefault(); // Mencegah navigasi ke URL href
    
            // Submit form logout
            document.getElementById('logout-form').submit();
        });
    </script>
  </body>
</html>
