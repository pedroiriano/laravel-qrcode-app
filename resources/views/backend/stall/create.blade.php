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
                        <option value="Kios" selected>Kios</option>
                        <option value="Los">Los</option>
                    </select>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">Luas</div>
                <div class="card-body">
                    <select class="form-control" id="area" name="area">
                        <option value="n/a" selected>Pilih Luas</option>
                        <option value="0 - 5 m2">0 - 5 m2</option>
                        <option value="6 - 10 m2">6 - 10 m2</option>
                        <option value="11 - 15 m2">11 - 15 m2</option>
                        <option value="16 - 20 m2">16 - 20 m2</option>
                    </select>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">Retribusi Harian</div>
                <div class="card-body">
                    <input class="form-control" id="retribution" name="retribution" type="number" placeholder="Masukkan Retribusi (contoh: 4500)" />
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

@section('js')
{{-- BEGIN::Triggered Form Section --}}
<script>
$("#stall").change(function() {
  if ($(this).val() == "Kios") {
    $('#area').show();
  } else {
    $('#area').hide();
  }
});
$("#stall").trigger("change");
</script>
{{-- END::Triggered Form Section --}}
@endsection
