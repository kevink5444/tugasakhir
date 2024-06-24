<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3 sidebar-sticky">
      <ul class="nav flex-column">
        <li class="nav-item">
          <a class="nav-link @if(request()->is('dashboard')) active @endif" aria-current="page" href="{{ route('dashboard') }}">
            <span data-feather="home" class="align-text-bottom"></span>
            Dashboard
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link @if(request()->is('absensi')) active @endif" href="{{ route('absensi.index') }}">
            <span data-feather="file" class="align-text-bottom"></span>
            Absensi
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link @if(request()->is('penggajian')) active @endif" href="{{ route('penggajian') }}">
            <span data-feather="shopping-cart" class="align-text-bottom"></span>
            Penggajian
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link @if(request()->is('karyawan')) active @endif" href="{{ route('karyawan.index') }}">
            <span data-feather="users" class="align-text-bottom"></span>
            Karyawan
          </a>
        </li>
          </a>
        </li>
      </ul>
    </div>
  </nav>
  