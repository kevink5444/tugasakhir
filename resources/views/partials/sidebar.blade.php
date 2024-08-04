<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
    <div class="position-sticky pt-3 sidebar-sticky">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link @if(request()->routeIs('dashboard')) active @endif" href="{{ route('dashboard') }}">
                    <span data-feather="home" class="align-text-bottom"></span>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if(request()->routeIs('absensi.index')) active @endif" href="{{ route('absensi.index') }}">
                    <span data-feather="file" class="align-text-bottom"></span>
                    Absensi
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if(request()->routeIs('penggajian.index')) active @endif" href="{{ route('penggajian.index') }}">
                    <span data-feather="shopping-cart" class="align-text-bottom"></span>
                    Gaji Borongan
                </a>
                <li class="nav-item">
                    <a class="nav-link @if(request()->routeIs('penggajian.index')) active @endif" href="{{ route('penggajian.index') }}">
                        <span data-feather="shopping-cart" class="align-text-bottom"></span>
                        Gaji Harian
                    </a>
                <li class="nav-item">
                    <a class="nav-link @if(request()->routeIs('penggajian.index')) active @endif" href="{{ route('penggajian.index') }}">
                        <span data-feather="shopping-cart" class="align-text-bottom"></span>
                        Gaji Bulanan
                    </a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if(request()->routeIs('karyawan.index')) active @endif" href="{{ route('karyawan.index') }}">
                    <span data-feather="users" class="align-text-bottom"></span>
                    Karyawan
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if(request()->routeIs('pekerjaan.index')) active @endif" href="{{ route('pekerjaan.index') }}">
                    <span data-feather="briefcase" class="align-text-bottom"></span>
                    Pekerjaan
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if(request()->routeIs('laporan.absensi')) active @endif" href="{{ route('laporan.absensi') }}">
                    <span data-feather="bar-chart-2" class="align-text-bottom"></span>
                    Laporan Absensi
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if(request()->routeIs('laporan.karyawan')) active @endif" href="{{ route('laporan.karyawan') }}">
                    <span data-feather="bar-chart-2" class="align-text-bottom"></span>
                    Laporan Karyawan
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if(request()->routeIs('laporan.penggajian')) active @endif" href="{{ route('laporan.penggajian') }}">
                    <span data-feather="bar-chart-2" class="align-text-bottom"></span>
                    Laporan Penggajian
                </a>
            </li>
        </ul>
    </div>
</nav>
