@extends('layouts.frontend')

@section('css')
<link rel="stylesheet" href="{{ asset('css/frontend/styles.css') }}">
@endsection

@section('content')
<section id="commodity-price" class="bg-light py-10">
    <div class="container px-3">
        <h2 class="mb-4">Daftar Kios atau Los</h2>
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
