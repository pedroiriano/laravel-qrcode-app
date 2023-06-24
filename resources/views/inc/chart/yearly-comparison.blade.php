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
                <div class="col-sm-4">
                    <select class="form-control" id="searchYear" name="searchYear">
                        @for ($i = 0; $i < 10; $i++)
                            <option value="{{ $dt-$i }}" {{ ($dt-$i) == ($year) ? 'selected' : '' }}>
                                {{ $dt-$i }}
                            </option>
                        @endfor
                    </select>
                </div>
                <label class="col-sm-2 col-form-label text-center">dan</label>
                <div class="col-sm-4">
                    <select class="form-control" id="searchYearCompare" name="searchYearCompare">
                        @for ($i = 0; $i < 10; $i++)
                            <option value="{{ $dt-$i }}" {{ ($dt-$i) == ($yearCompare) ? 'selected' : '' }}>
                                {{ $dt-$i }}
                            </option>
                        @endfor
                    </select>
                </div>
            </div>
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