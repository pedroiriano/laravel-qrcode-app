@if (session('success'))
    <div class="alert alert-success alert-icon" role="alert">
        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
        <div class="alert-icon-aside">
            <i data-feather="alert-circle"></i>
        </div>
        <div class="alert-icon-content">
            {{ session('success') }}
        </div>
    </div>
    <span class="badge rounded-pill bg-danger mb-3">{{ session('status') }}</span>
@elseif (session('error'))
    <div class="alert alert-danger alert-icon" role="alert">
        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
        <div class="alert-icon-aside">
            <i data-feather="alert-circle"></i>
        </div>
        <div class="alert-icon-content">
            {{ session('error') }}
        </div>
    </div>
@elseif (session('status'))
    <div class="alert alert-warning alert-icon" role="alert">
        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
        <div class="alert-icon-aside">
            <i data-feather="alert-circle"></i>
        </div>
        <div class="alert-icon-content">
            {{ session('status') }}
        </div>
    </div>
@else

@endif
