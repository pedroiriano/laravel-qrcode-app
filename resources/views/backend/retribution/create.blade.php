@extends('layouts.backend')

@section('css')
<link rel="stylesheet" href="{{ asset('css/backend/styles.css') }}">
<script src="https://cdn.jsdelivr.net/npm/@easepick/bundle@1.2.1/dist/index.umd.min.js"></script>
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
                        Tambah Retribusi
                    </h1>
                </div>
                <div class="col-12 col-xl-auto mb-3">
                    <a class="btn btn-sm btn-light text-primary" href="{{ route('retribution') }}">
                        <i class="me-1" data-feather="arrow-left"></i>
                        Kembali ke Tabel Retribusi
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Main page content-->
<form id="retributionForm" action="{{ route('retribution-store') }}" method="POST" enctype="multipart/form-data">
@csrf
<div class="container-fluid px-4">
    @include('inc.alert-message')
    <div class="row gx-4">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">Tempat Sewa</div>
                <div class="card-body">
                    <select class="form-control js-example-basic-single" id="rent" name="rent">
                        @foreach ($rens as $ren_id => $ren)
                        <option value="{{ $ren_id }}">{{ $ren }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">Jumlah Hutang</div>
                <div class="card-body">
                    <input class="form-control" id="due_amount" name="due_amount" type="text" placeholder="Jumlah Hutang dalam Rupiah" disabled />
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">Retribusi Harian</div>
                <div class="card-body">
                    <input class="form-control" id="daily_retribution" name="daily_retribution" type="text" placeholder="Jumlah Retribusi Harian dalam Rupiah" disabled />
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">Jumlah Retribusi</div>
                <div class="card-body">
                    <input class="form-control" id="amount" name="amount" type="number" placeholder="Masukkan Retribusi dalam Rupiah (contoh: 4500)" required />
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">Tanggal Bayar</div>
                <div class="card-body">
                    <div class="input-group input-group-joined">
                        <span class="input-group-text"><i data-feather="calendar"></i></span>
                        <input class="form-control pointer" id="datepicker" name="retribution_date" placeholder="Pilih Tanggal" required />
                    </div>
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
<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// $(document).ready(function() {
//     $("#rent").change(function() {
//         var rentId = $(this).val();

//         $.ajax({
//             url: "{{ route('get-due-amount') }}",
//             type: "POST",
//             data: { rent_id: rentId },
//             success: function(response) {
//                 var formattedDueAmount = formatToRupiah(response.due_amount);
//                 var formattedDailyRetribution = formatToRupiah(response.daily_retribution);
//                 $('#due_amount').val(formattedDueAmount);
//                 $('#daily_retribution').val(formattedDailyRetribution);
//             },
//             error: function(xhr, status, error) {
//                 console.error(error);
//             }
//         });
//     });

//     $("#rent").trigger("change");
// });

// function formatToRupiah(number) {
//     return number.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' });
// }
// </script>

<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function() {
    $("#rent").change(function() {
        var rentId = $(this).val();

        $.ajax({
            url: "{{ route('get-due-amount') }}",
            type: "POST",
            data: { rent_id: rentId },
            success: function(response) {
                var formattedDueAmount = isNaN(response.due_amount) ? 'N/A' : formatToRupiah(response.due_amount);

                var formattedDailyRetribution = isNaN(response.daily_retribution) ? 'N/A' : formatToRupiah(response.daily_retribution);

                $('#due_amount').val(formattedDueAmount);
                $('#daily_retribution').val(formattedDailyRetribution);
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });

    $("#rent").trigger("change");
});

function formatToRupiah(number) {
    if (isNaN(number)) {
        return 'N/A';
    }
    return number.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' });
}
</script>

<script>
    const picker = new easepick.create({
        element: document.getElementById('datepicker'),
        css: [
            'https://cdn.jsdelivr.net/npm/@easepick/bundle@1.2.1/dist/index.css',
        ],
    });
</script>

<script>
function validateForm() {
    var retributionDate = document.getElementById("datepicker").value;
    if (retributionDate === "") {
        alert("Tanggal Bayar Harus Diisi!");
        return false;
    }
    return true;
}

document.getElementById("retributionForm").addEventListener("submit", function(event) {
    if (!validateForm()) {
        event.preventDefault();
    }
});
</script>

<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });
</script>
@endsection
