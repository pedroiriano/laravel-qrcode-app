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
                        Tambah Pedagang
                    </h1>
                </div>
                <div class="col-12 col-xl-auto mb-3">
                    <a class="btn btn-sm btn-light text-primary" href="{{ route('merchant') }}">
                        <i class="me-1" data-feather="arrow-left"></i>
                        Kembali ke Tabel Pedagang
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Main page content-->
<form action="{{ route('merchant-store') }}" method="POST" enctype="multipart/form-data">
@csrf
<div class="container-fluid px-4">
    @include('inc.alert-message')
    <div class="row gx-4">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">NIK</div>
                <div class="card-body">
                    <input class="form-control" id="identity" name="identity" type="number" placeholder="Masukkan NIK (contoh: 3274030000000006)" />
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">Nama</div>
                <div class="card-body"><input class="form-control" id="name" name="name" type="text" placeholder="Masukkan Nama (contoh: Pedro Iriano)" /></div>
            </div>
            <div class="card mb-4">
                <div class="card-header">Alamat</div>
                <div class="card-body">
                    <textarea class="lh-base form-control" id="address" name="address" type="text" placeholder="Alamat Rumah (contoh: Pesona Cilebut 2 Blok BB No. 11)" rows="4"></textarea>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">Telepon</div>
                <div class="card-body">
                    <input class="form-control" id="phone" name="phone" type="number" placeholder="Masukkan Nomor Telepon/HP (contoh: 08999999999)" />
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">Foto</div>
                <div class="card-body"><input class="form-control" id="photo" name="photo" type="file" /></div>
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
