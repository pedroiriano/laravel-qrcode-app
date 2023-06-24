<form action="{{ route('dashboard-commodity-single') }}" method="GET">
    @csrf
    <div class="row mb-4">
        <div class="col-xl-6 col-md-6 col-sm-12 col-xs-12">
            <label for="searchCommodity">Komoditas</label>
            <select class="form-control" id="searchCommodity" name="searchCommodity">
                @if (count($coms) > 0)
                    @foreach ($coms as $com)
                        <option value="{{ $com->id }}" {{ ($com->id) == ($commodity) ? 'selected' : '' }}>{{ $com->name }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class="col-xl-6 col-md-6 col-sm-12 col-xs-12">
            <label for="searchYear">Tahun</label>
            <select class="form-control" id="searchYear" name="searchYear">
                @for ($i = 0; $i < 10; $i++)
                    <option value="{{ $dt-$i }}" {{ ($dt-$i) == ($year) ? 'selected' : '' }}>
                        {{ $dt-$i }}
                    </option>
                @endfor
            </select>
        </div>
    </div>
    <input type="hidden" name="pillId" value="3">
    <div class="row mb-4">
        <div class="col position-relative me-2">
            <button type="submit" class="btn btn-primary position-absolute end-0">
                <a class="text-decoration-none text-white">
                    Grafik
                </a>
            </button>
        </div>
    </div>
</form>