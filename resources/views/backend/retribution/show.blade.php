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
                        <div class="page-header-icon"><i data-feather="coffee"></i></div>
                        Detail Sewa
                    </h1>
                </div>
                <div class="col-12 col-xl-auto mb-3">
                    <a class="btn btn-sm btn-light text-primary" href="/rent/{{ $ren->id }}/edit">
                        <i class="me-1" data-feather="edit"></i>
                        Ubah
                    </a>
                    <a class="btn btn-sm btn-light text-primary" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <i class="me-1" data-feather="trash-2"></i>
                        Hapus
                    </a>
                    <a class="btn btn-sm btn-light text-primary" href="{{ route('rent') }}">
                        <i class="me-1" data-feather="arrow-left"></i>
                        Kembali ke Tabel Sewa
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Main page content-->
<div class="container-fluid px-4">
    @include('inc.alert-message')
    <div class="card">
        <div class="card-header">Informasi Tempat</div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ms-0">
                        <div class="row small text-muted fw-bold">
                            <div class="col-6">
                                Jenis Tempat
                            </div>
                            <div class="col-6">
                                {{ $ren->stall_type }}
                            </div>
                        </div>
                        <div class="row small text-muted fw-bold">
                            <div class="col-6">
                                Luas Tempat
                            </div>
                            <div class="col-6">
                                {{ $ren->stall_area }}
                            </div>
                        </div>
                        <div class="row small text-muted fw-bold">
                            <div class="col-6">
                               Retribusi Tempat
                            </div>
                            <div class="col-6">
                                {{ $ren->stall_retribution }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card mt-3">
        <div class="card-header">Informasi Pedagang</div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ms-0">
                        <div class="row small text-muted fw-bold">
                            <div class="col-6">
                                NIK Pedagang
                            </div>
                            <div class="col-6">
                                {{ $ren->merchant_identity }}
                            </div>
                        </div>
                        <div class="row small text-muted fw-bold">
                            <div class="col-6">
                                Nama Pedagang
                            </div>
                            <div class="col-6">
                                {{ $ren->merchant_name }}
                            </div>
                        </div>
                        <div class="row small text-muted fw-bold">
                            <div class="col-6">
                               Telepon Pedagang
                            </div>
                            <div class="col-6">
                                {{ $ren->merchant_phone }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card mt-3">
        <div class="card-header">Informasi Sewa</div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ms-0">
                        <div class="row small text-muted fw-bold">
                            <div class="col-6">
                                Lokasi
                            </div>
                            <div class="col-6">
                                {{ $ren->location }}
                            </div>
                        </div>
                        <div class="row small text-muted fw-bold">
                            <div class="col-6">
                                Jenis Jualan
                            </div>
                            <div class="col-6">
                                {{ $ren->trade_type }}
                            </div>
                        </div>
                        <div class="row small text-muted fw-bold">
                            <div class="col-6">
                               Status
                            </div>
                            <div class="col-6">
                                {{ $ren->status }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalTitle">Hapus Data</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">Yakin Ingin Menghapus Data?</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">
                    Tidak
                </button>
                <form class="btn" action="{{ route('rent-delete', $ren->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-primary">
                        <a class="text-decoration-none text-white">
                            Ya
                        </a>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
