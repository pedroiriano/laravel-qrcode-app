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
                        Tambah Pengguna
                    </h1>
                </div>
                <div class="col-12 col-xl-auto mb-3">
                    <a class="btn btn-sm btn-light text-primary" href="{{ route('user') }}">
                        <i class="me-1" data-feather="arrow-left"></i>
                        Kembali ke Tabel Pengguna
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Main page content-->
<form action="{{ route('user-update', $use->id) }}" method="POST" enctype="multipart/form-data">
@csrf
@method('PUT')
<div class="container-fluid px-4">
    @include('inc.alert-message')
    <div class="row gx-4">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">Nama Pengguna</div>
                <div class="card-body">
                    <input class="form-control" id="user" name="user" type="text" placeholder="Masukkan Nama Pengguna (contoh: UPT Pasar Agung Depok)" value="{{ $use->name }}" />
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">Alamat Email</div>
                <div class="card-body">
                    <input class="form-control" id="email" name="email" type="email" placeholder="Masukkan Alamat Email (contoh: agungdepok@depok.go.id)" value="{{ $use->email }}" />
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">Kata Sandi</div>
                <div class="card-body">
                    <input class="form-control" id="password" name="password" type="password" placeholder="Masukkan Kata Sandi Minimal 9 Karakter (contoh: 123456789)" />
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">Ulangi Kata Sandi</div>
                <div class="card-body">
                    <input class="form-control" id="password-confirm" name="password_confirmation" type="password" placeholder="Masukkan Kata Sandi Minimal 9 Karakter (contoh: 123456789)" />
                </div>
            </div>
            @if ($user->role_id == 1)
            <div class="card mb-4">
                <div class="card-header">Wewenang</div>
                <div class="card-body">
                    <select class="form-control" id="role" name="role">
                        @if (count($rols) > 0)
                            @foreach ($rols as $rol)
                                <option value="{{ $rol->id }}" {{ $rol->id == $use->role_id ? 'selected' : '' }}>
                                    {{ $rol->name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">Status</div>
                <div class="card-body">
                    <select class="form-control" id="status" name="status">
                        <option value="Aktif" {{ $use->status == 'Aktif' ? 'selected' : '' }}>
                            Aktif
                        </option>
                        <option value="Tidak Aktif" {{ $use->status == 'Tidak Aktif' ? 'selected' : '' }}>
                            Tidak Aktif
                        </option>
                    </select>
                </div>
            </div>
            @endif
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
