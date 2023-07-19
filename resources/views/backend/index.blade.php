@extends('layouts.backend')

@section('css')
<link rel="stylesheet" href="{{ asset('css/backend/styles.css') }}">
@endsection

@section('content')
<!-- Main Content-->
<header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
    <div class="container-xl px-4">
        <div class="page-header-content pt-4">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto mt-4">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="activity"></i></div>
                        Beranda Admin Sidita
                    </h1>
                    <div class="page-header-subtitle">Beranda Admin Sidita UPTD Pasar Kemirimuka Kota Depok</div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Main page content-->
<div class="container-xl px-4 mt-n10">
    <div class="row">
        <div class="col-xxl-4 col-xl-12 mb-4">
            <div class="card h-100">
                <div class="card-body h-100 p-5">
                    <div class="row align-items-center">
                        <div class="col-xl-8 col-xxl-12">
                            <div class="text-center text-xl-start text-xxl-center mb-4 mb-xl-0 mb-xxl-4">
                                <h1 class="text-primary">Selamat Datang di Sidita</h1>
                                <p class="text-gray-700 mb-0">Sistem Digital Data Pedagang di UPTD Pasar Kemirimuka Kota Depok</p>
                            </div>
                        </div>
                        <div class="col-xl-4 col-xxl-12 text-center"><img class="img-fluid" src="{{ asset('images/illustrations/office-sidata.jpg') }}" style="max-width: 20rem" /></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
