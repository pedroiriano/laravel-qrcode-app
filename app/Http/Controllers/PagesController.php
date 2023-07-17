<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Rent;

class PagesController extends Controller
{
    public function index()
    {
        $rens = DB::table('rents')
            ->join('stalls', 'rents.stall_id', '=', 'stalls.id')
            ->join('merchants', 'rents.merchant_id', '=', 'merchants.id')
            ->leftJoin('stall_types', 'stalls.stall_type_id', '=', 'stall_types.id')
            ->select('rents.*', 'stalls.stall_type_id', 'stalls.location', 'stalls.area as stall_area', 'merchants.identity as merchant_identity', 'merchants.name as merchant_name', 'merchants.phone as merchant_phone', 'stall_types.stall_type', 'stall_types.retribution as stall_retribution')
            ->paginate(6);

        return view('pages.index')->with('rens', $rens);
    }
}
