@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-start">
        @if (!empty($users))
            @foreach ($users as $user)
                <div class="col-md-4">
                    <div class="card text-center mb-3">
                        <div class="card-header">
                            {{ $user ? $user->name : 'No Name' }}
                        </div>
                        <div class="card-body">
                            @if (!empty($user->photo))
                                <img src="{{ asset('storage/img/qr-code/'.$user->photo) }}" alt="User QR">
                            @else
                                <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(200)->generate('Default User')) !!}">
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
@endsection
