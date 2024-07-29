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
              <a class="nav-link @if(request()->is('penggajian')) active @endif" href="{{ route('penggajian.index') }}">
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
          <li class="nav-item">
              <a class="nav-link @if(request()->is('capaian')) active @endif" href="{{ route('capaian.index') }}">
                  <span data-feather="check-square" class="align-text-bottom"></span>
                  Capaian
              </a>
          </li>
          <li class="nav-item">
              <a class="nav-link @if(request()->is('pekerjaan')) active @endif" href="{{ route('pekerjaan.store') }}">
                  <span data-feather="briefcase" class="align-text-bottom"></span>
                  Pekerjaan
              </a>
          </li>
          <li class="nav-item">
              <a class="nav-link @if(request()->is('pengaturan_target')) active @endif" href="{{ route('pengaturan_target.index') }}">
                  <span data-feather="target" class="align-text-bottom"></span>
                  Target
              </a>
          </li>
          <li class="nav-item">
              <a class="nav-link @if(request()->is('laporan/absensi')) active @endif" href="{{ route('laporan.absensi') }}">
                  <span data-feather="bar-chart-2" class="align-text-bottom"></span>
                  Laporan Absensi
              </a>
          </li>
          <li class="nav-item">
              <a class="nav-link @if(request()->is('laporan/karyawan')) active @endif" href="{{ route('laporan.karyawan') }}">
                  <span data-feather="bar-chart-2" class="align-text-bottom"></span>
                  Laporan Karyawan
              </a>
          </li>
          <li class="nav-item">
              <a class="nav-link @if(request()->is('laporan/penggajian')) active @endif" href="{{ route('laporan.penggajian') }}">
                  <span data-feather="bar-chart-2" class="align-text-bottom"></span>
                  Laporan Penggajian
              </a>
          </li>
      </ul>
  </div>
</nav>
