<div id="layoutSidenav_nav">
    <nav class="sidenav shadow-right sidenav-light">
        <div class="sidenav-menu">
            <div class="nav accordion" id="accordionSidenav">
                <!-- Sidenav Menu Heading (Core)-->
                <div class="sidenav-menu-heading">Informasi Utama</div>
                <!-- Sidenav Accordion (Dashboard)-->
                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseDashboards" aria-expanded="false" aria-controls="collapseDashboards">
                    <div class="nav-link-icon"><i data-feather="activity"></i></div>
                    Dasbor
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseDashboards" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavDashboards">
                        <a class="nav-link" href="">
                            Statistik Umum
                        </a>
                        <a class="nav-link" href="">
                            Statistik Retribusi
                        </a>
                    </nav>
                </div>
                <!-- Sidenav Heading (Management)-->
                <div class="sidenav-menu-heading">Manajemen Data</div>
                <!-- Sidenav Accordion (Commodity)-->
                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseCommodities" aria-expanded="false" aria-controls="collapseCommodities">
                    <div class="nav-link-icon"><i data-feather="package"></i></div>
                    Retribusi
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseCommodities" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav accordion">
                        <a class="nav-link" href="">
                            Tabel Retribusi
                        </a>
                        @if (auth()->user()->role_id == 1)
                        <a class="nav-link" href="">
                            Perbarui Retribusi
                        </a>
                        @endif
                    </nav>
                </div>
                @if (auth()->user()->role_id == 1)
                <!-- Sidenav Accordion (Region)-->
                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseRegions" aria-expanded="false" aria-controls="collapseRegions">
                    <div class="nav-link-icon"><i data-feather="map"></i></div>
                    Kios atau Los
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseRegions" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav accordion">
                        <a class="nav-link" href="{{ route('stall') }}">
                            Tabel Kios/Los
                        </a>
                        <a class="nav-link" href="{{ route('stall-form') }}">
                            Tambah Kios/Los
                        </a>
                    </nav>
                </div>
                <!-- Sidenav Accordion (User)-->
                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseUsers" aria-expanded="false" aria-controls="collapseUsers">
                    <div class="nav-link-icon"><i data-feather="users"></i></div>
                    Pengguna
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseUsers" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('role') }}">
                            Tabel Wewenang
                        </a>
                        <a class="nav-link" href="{{ route('role-form') }}">
                            Tambah Wewenang
                        </a>
                        <a class="nav-link" href="{{ route('user') }}">
                            Tabel Pengguna
                        </a>
                        <a class="nav-link" href="{{ route('user-form') }}">
                            Tambah Pengguna
                        </a>
                    </nav>
                </div>
                @endif
                <!-- Sidenav Heading (Pages)-->
                <div class="sidenav-menu-heading">Laman</div>
                <!-- Sidenav Link (Home)-->
                <a class="nav-link" href="{{ route('backend') }}">
                    <div class="nav-link-icon"><i data-feather="home"></i></div>
                    Beranda
                </a>
                <a class="nav-link" href="{{ route('home') }}">
                    <div class="nav-link-icon"><i data-feather="globe"></i></div>
                    Halaman Depan
                </a>
            </div>
        </div>
        <!-- Sidenav Footer-->
        <div class="sidenav-footer">
            <div class="sidenav-footer-content">
                <div class="sidenav-footer-subtitle">Masuk sebagai:</div>
                <div class="sidenav-footer-title">{{ auth()->user()->name }}</div>
            </div>
        </div>
    </nav>
</div>
