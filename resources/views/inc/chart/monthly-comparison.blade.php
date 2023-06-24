<form action="{{ route('dashboard-commodity-comparison') }}" method="GET">
    @csrf
    <div class="row mb-4">
        <div class="col-sm-12 col-xs-12 mb-2">
            <div class="form-group row">
                <label for="searchCommodity" class="col-sm-2 col-form-label">Komoditas</label>
                <div class="col-sm-10">
                    <select class="form-control" id="searchCommodity" name="searchCommodity">
                        @if (count($coms) > 0)
                            @foreach ($coms as $com)
                                <option value="{{ $com->id }}" {{ ($com->id) == ($commodity) ? 'selected' : '' }}>{{ $com->name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-xs-12">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Periode</label>
                <div class="col-sm-3">
                    <select class="form-control" id="searchYear" name="searchYear">
                        @for ($i = 0; $i < 10; $i++)
                            <option value="{{ $dt-$i }}" {{ ($dt-$i) == ($year) ? 'selected' : '' }}>
                                {{ $dt-$i }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="col-sm-3">
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
                <label class="col-sm-1 col-form-label text-center">dan</label>
                <div class="col-sm-3">
                    <select class="form-control" id="searchMonthCompare" name="searchMonthCompare">
                        <option value="01" {{ ($monthCompare) == '01' ? 'selected' : '' }}>
                            Januari
                        </option>
                        <option value="02" {{ ($monthCompare) == '02' ? 'selected' : '' }}>
                            Februari
                        </option>
                        <option value="03" {{ ($monthCompare) == '03' ? 'selected' : '' }}>
                            Maret
                        </option>
                        <option value="04" {{ ($monthCompare) == '04' ? 'selected' : '' }}>
                            April
                        </option>
                        <option value="05" {{ ($monthCompare) == '05' ? 'selected' : '' }}>
                            Mei
                        </option>
                        <option value="06" {{ ($monthCompare) == '06' ? 'selected' : '' }}>
                            Juni
                        </option>
                        <option value="07" {{ ($monthCompare) == '07' ? 'selected' : '' }}>
                            Juli
                        </option>
                        <option value="08" {{ ($monthCompare) == '08' ? 'selected' : '' }}>
                            Agustus
                        </option>
                        <option value="09" {{ ($monthCompare) == '09' ? 'selected' : '' }}>
                            September
                        </option>
                        <option value="10" {{ ($monthCompare) == '10' ? 'selected' : '' }}>
                            Oktober
                        </option>
                        <option value="11" {{ ($monthCompare) == '11' ? 'selected' : '' }}>
                            November
                        </option>
                        <option value="12" {{ ($monthCompare) == '12' ? 'selected' : '' }}>
                            Desember
                        </option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="pillId" value="2">
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