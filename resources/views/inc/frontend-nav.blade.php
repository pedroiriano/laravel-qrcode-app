<!-- Navbar-->
<nav class="navbar navbar-marketing navbar-expand-lg bg-white navbar-light">
    <div class="container px-5">
        <a class="navbar-brand text-dark" href="/">
            <img src="{{ asset('images/brand/pasar.png') }}" alt="" class="d-inline-block align-text-top">
            SIDONNA
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i data-feather="menu"></i></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto me-lg-5">
                <li class="nav-item"><a class="nav-link" href="/">Beranda</a></li>
                <li class="nav-item dropdown dropdown-xl no-caret">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownDemos" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Kios/Los
                        <i class="fas fa-chevron-right dropdown-arrow"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end animated--fade-in-up me-lg-n25 me-xl-n15" aria-labelledby="navbarDropdownDemos">
                        <div class="row g-0">
                            <div class="col-lg-5 p-lg-3 bg-img-cover overlay overlay-primary overlay-70 d-none d-lg-block" style="background-image: url('assets/img/backgrounds/bg-dropdown-xl.jpg')">
                                <div class="d-flex h-100 w-100 align-items-center justify-content-center">
                                    <div class="text-white text-center z-1">
                                        <div class="mb-3">Daftar semua Kios/Los di Pasar Kemirimuka Kota Depok dapat dilihat di sini:</div>
                                        <a class="btn btn-white btn-sm text-primary fw-500" href="/">Lihat Semua</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-7 p-lg-5">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h6 class="dropdown-header text-primary">Kios</h6>
                                        {{-- @if (count($frontNavCats) > 0)
                                            @foreach ($frontNavCats as $frontNavCat)
                                                <a class="dropdown-item" href="/">{{ $frontNavCat->name }}</a>
                                            @endforeach
                                        @endif --}}
                                        <div class="dropdown-divider border-0 d-lg-none"></div>
                                    </div>
                                    <div class="col-lg-6">
                                        <h6 class="dropdown-header text-primary">Los</h6>
                                        {{-- @if (count($frontNavMars) > 0)
                                            @foreach ($frontNavMars as $frontNavMar)
                                                <a class="dropdown-item" href="/">{{ $frontNavMar->name }}</a>
                                            @endforeach
                                        @endif --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
            @auth
            <a class="btn fw-500 ms-lg-4 btn-teal" href="{{ route('backend') }}">
                Masuk
                <i class="ms-2" data-feather="arrow-right"></i>
            </a>
            @endauth
        </div>
    </div>
</nav>
