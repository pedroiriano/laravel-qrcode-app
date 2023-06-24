<form action="{{ route('dashboard-commodity-single') }}" method="GET">
    @csrf
    <div class="row mb-4">
        <div class="col-xl-4 col-md-4 col-sm-12 col-xs-12">
            <label for="searchCommodity">Komoditas</label>
            <select class="form-control" id="searchCommodity" name="searchCommodity">
                @if (count($coms) > 0)
                    @foreach ($coms as $com)
                        <option value="{{ $com->id }}" {{ ($com->id) == ($commodity) ? 'selected' : '' }}>{{ $com->name }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class="col-xl-4 col-md-4 col-sm-12 col-xs-12">
            <label for="searchYear">Tahun</label>
            <select class="form-control" id="searchYear" name="searchYear">
                @for ($i = 0; $i < 10; $i++)
                    <option value="{{ $dt-$i }}" {{ ($dt-$i) == ($year) ? 'selected' : '' }}>
                        {{ $dt-$i }}
                    </option>
                @endfor
            </select>
        </div>
        <div class="col-xl-4 col-md-4 col-sm-12 col-xs-12">
            <label for="searchMonth">Bulan</label>
            <select class="form-control" id="searchMonth" name="searchMonth">
                <option value="01" {{ ($month) == '01' ? 'selected' : '' }}>
                    Januari
                </option>
                <option value="02" {{ ($month) == '02' ? 'selected' : '' }}>
                    Februari
                </option>
                <option value="03" {{ ($month) == '03' ? 'selected' : '' }}>
                    Maret
                </option>
                <option value="04" {{ ($month) == '04' ? 'selected' : '' }}>
                    April
                </option>
                <option value="05" {{ ($month) == '05' ? 'selected' : '' }}>
                    Mei
                </option>
                <option value="06" {{ ($month) == '06' ? 'selected' : '' }}>
                    Juni
                </option>
                <option value="07" {{ ($month) == '07' ? 'selected' : '' }}>
                    Juli
                </option>
                <option value="08" {{ ($month) == '08' ? 'selected' : '' }}>
                    Agustus
                </option>
                <option value="09" {{ ($month) == '09' ? 'selected' : '' }}>
                    September
                </option>
                <option value="10" {{ ($month) == '10' ? 'selected' : '' }}>
                    Oktober
                </option>
                <option value="11" {{ ($month) == '11' ? 'selected' : '' }}>
                    November
                </option>
                <option value="12" {{ ($month) == '12' ? 'selected' : '' }}>
                    Desember
                </option>
            </select>
        </div>
    </div>
    <input type="hidden" name="pillId" value="1">
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