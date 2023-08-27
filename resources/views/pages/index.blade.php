@extends('layouts.frontend')

@section('css')
<link rel="stylesheet" href="{{ asset('css/frontend/styles.css') }}">
@endsection

@section('content')
<header class="page-header-ui page-header-ui-light bg-img-cover" style="background-image: url({{ asset('images/illustrations/sidita-background.png') }})">
    <div class="page-header-ui-content">
        <div class="container px-5">
            <div class="row gx-5 justify-content-center">
                <div class="col-xl-8 col-lg-10 text-center">
                    @include('inc.alert-message')
                    <h1 class="page-header-ui-title fw-bold text-white">
                        <span style="background-color: rgba(128, 128, 128, 0.75); display: inline; border-radius: 10px; text-shadow: 2px 2px #000000">
                            SIDITA
                        </span>
                    </h1>
                    <p class="page-header-ui-text fw-bold mb-5 text-white">
                        <span style="background-color: rgba(128, 128, 128, 0.75); display: inline; border-radius: 10px; text-shadow: 2px 2px #000000">
                            Sistem Digital Data Pedagang
                        </span>
                    </p>
                    <p class="page-header-ui-text fw-bold mb-5 text-white">
                        <span style="background-color: rgba(128, 128, 128, 0.75); display: inline; border-radius: 10px; text-shadow: 2px 2px #000000">
                            UPTD Pasar Kemirimuka Kota Depok
                        </span>
                    </p>
                    @auth
                    <a class="btn btn-teal fw-bold me-2" href="{{ route('backend') }}">Masuk Sistem</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</header>
<section id="commodity-price" class="bg-light py-10">
    <div class="container px-3">
        <h2 class="mb-4">Daftar Sewa Kios atau Los</h2>
        <div class="row gx-3">
            @if (!empty($rens))
                @foreach ($rens as $ren)
                    <div class="col-md-4">
                        <div class="card text-center mb-3">
                            <div class="card-header">
                                {{ $ren ? $ren->merchant_name : 'No Name' }} {{ $ren ? $ren->stall_type : 'No Stall Type' }} {{ $ren ? $ren->location : 'No Location' }}
                            </div>
                            <div class="card-body">
                                @if (!empty($ren->qr))
                                    <img src="{{ asset('storage/img/qr-code/'.$ren->qr) }}" alt="Rent QR">
                                @else
                                    <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(200)->generate('Default Rent')) !!}">
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="d-flex justify-content-center">
            {{ $rens->links('pagination::bootstrap-5') }}
        </div>
    </div>
</section>
@endsection
