@extends('layouts.auth')

@section('content')
<main class="form-signin">
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <a href="{{ route('home') }}">
            <img class="mb-4" src="{{ asset('images/brand/pasar.png') }}" alt="" width="150">
        </a>
        <h1 class="h3 mb-3 fw-normal">{{ __('Silakan Masuk') }}</h1>
        @if (session('status'))
            <span class="badge rounded-pill bg-danger mb-3">{{ session('status') }}</span>
        @endif
        <div class="form-floating">
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Alamat Email" value="{{ old('email') }}" data-bs-toggle="tooltip" data-bs-html="true" title="<em>Petunjuk:</em> isilah Alamat Email <u>dengan format</u> <b>contoh@contoh.com</b>" required autocomplete="email">
            <label for="email">{{ __('Alamat Email') }}</label>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-floating">
            <input type="password" name="password" class="form-control @error('email') is-invalid @enderror" id="password" placeholder="Kata Sandi" data-bs-toggle="tooltip" data-bs-html="true" title="<em>Petunjuk:</em> isilah Kata Sandi <u>dengan</u> <b>Minimal 9 Karakter</b>" required autocomplete="new-password">
            <label for="password">{{ __('Kata Sandi') }}</label>
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="checkbox mt-3 mb-3">
            <label>
            <input type="checkbox" name="remember"> Ingat Saya
            </label>
        </div>
        <button class="w-100 btn btn-lg btn-primary" type="submit">{{ __('Masuk') }}</button>
        {{-- <a class="btn btn-link" href="{{ route('register') }}">{{ __('Belum Punya Akun?') }}</a> --}}
        <p class="mt-5 mb-3 text-muted">&copy; <script>document.write(new Date().getFullYear())</script></p>
    </form>
</main>
@endsection

@section('js')
<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
@endsection
