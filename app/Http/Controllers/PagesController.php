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
            ->select('rents.*', 'stalls.stall_type', 'stalls.area as stall_area', 'merchants.identity as merchant_identity', 'merchants.name as merchant_name', 'merchants.phone as merchant_phone')
            ->paginate(6);

        return view('pages.index')->with('rens', $rens);
    }
}
