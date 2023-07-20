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
                        Tambah Sewa
                    </h1>
                </div>
                <div class="col-12 col-xl-auto mb-3">
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
<form action="{{ route('rent-store') }}" method="POST" enctype="multipart/form-data">
@csrf
<div class="container-fluid px-4">
    @include('inc.alert-message')
    <div class="row gx-4">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">Jenis Tempat</div>
                <div class="card-body">
                    <select class="form-control" id="stall" name="stall">
                        @foreach ($stas as $sta_id => $sta)
                        <option value="{{ $sta_id }}">{{ $sta }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">Pedagang</div>
                <div class="card-body">
                    <select class="form-control" id="merchant" name="merchant">
                        @foreach ($mers as $mer_id => $mer)
                        <option value="{{ $mer_id }}">{{ $mer }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">Jenis Jualan</div>
                <div class="card-body"><input class="form-control" id="trade_type" name="trade_type" type="text" placeholder="Jenis Jualan (contoh: Sayuran)" /></div>
            </div>
            {{-- <div class="card mb-4">
                <div class="card-header">Bayar Biaya Tahunan</div>
                <div class="card-body"><input class="form-control" id="pay_cost" name="pay_cost" type="text" placeholder="Berapa Kali Biaya Tahunan (contoh: 2)" /></div>
            </div> --}}
            <div class="card mb-4">
                <div class="card-header">Tanggal Bayar</div>
                <div class="card-body">
                    <div class="input-group input-group-joined">
                        <span class="input-group-text"><i data-feather="calendar"></i></span>
                        <input class="form-control ps-0 pointer" id="litepickerSingleDate" name="start" placeholder="Pilih Tanggal" />
                    </div>
                </div>
            </div>
            {{-- <div class="card mb-4">
                <div class="card-header">Status</div>
                <div class="card-body">
                    <select class="form-control" id="status" name="status">
                        <option value="Aktif" selected>Aktif</option>
                        <option value="Tidak Aktif">Tidak Aktif</option>
                    </select>
                </div>
            </div> --}}
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
