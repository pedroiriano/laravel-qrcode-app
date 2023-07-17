@extends('layouts.backend')

@section('css')
<link rel="stylesheet" href="{{ asset('css/backend/styles.css') }}">
@endsection

@section('content')
<!-- Main Content-->
<header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
    <div class="container-fluid px-4">
        <div class="page-header-content">
            <div class="row align-items-center justify-content-between pt-3">
                <div class="col-auto mb-3">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="file-plus"></i></div>
                        Tambah Kios/Los
                    </h1>
                </div>
                <div class="col-12 col-xl-auto mb-3">
                    <a class="btn btn-sm btn-light text-primary" href="{{ route('stall') }}">
                        <i class="me-1" data-feather="arrow-left"></i>
                        Kembali ke Tabel Kios/Los
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Main page content-->
<form action="{{ route('stall-store') }}" method="POST" enctype="multipart/form-data">
@csrf
<div class="container-fluid px-4">
    @include('inc.alert-message')
    <div class="row gx-4">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">Jenis Tempat</div>
                <div class="card-body">
                    <select class="form-control" id="stall" name="stall">
                        @foreach ($stys as $sty_id => $sty)
                        <option value="{{ $sty_id }}">{{ $sty }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">Lokasi</div>
                <div class="card-body"><input class="form-control" id="location" name="location" type="text" placeholder="Lokasi Jualan" /></div>
            </div>
            <div class="card mb-4">
                <div class="card-header">Luas</div>
                <div class="card-body">
                    <input class="form-control" id="area" name="area" type="number" placeholder="Masukkan Luas Kios/Los dalam M2 (contoh: 5)" />
                </div>
            </div>
        </div>
        <!-- Sticky Navigation-->
        <div class="col-lg-4">
            <div class="nav-sticky">
                <div class="card card-header-actions">
                    <div class="card-header">
                        Aksi
                        <i class="text-muted" data-feather="info" data-bs-toggle="tooltip" data-bs-placement="left" title="Tombol Ulang untuk mengosongkan formulir isian, sedangkan tombol Simpan untuk menyimpan data."></i>
                    </div>
                    <div class="card-body">
                        <div class="d-grid mb-3"><button type="reset" class="fw-500 btn btn-primary-soft text-primary">Ulang</button></div>
                        <div class="d-grid"><button type="submit" class="fw-500 btn btn-primary">Simpan</button></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
@endsection
