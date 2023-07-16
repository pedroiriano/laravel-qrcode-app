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
            ->join('stall_types', 'rents.stall_id', '=', 'stall_types.id')
            ->join('merchants', 'rents.merchant_id', '=', 'merchants.id')
            ->select('rents.*', 'stall_types.stall_type', 'stall_types.area as stall_area', 'merchants.identity as merchant_identity', 'merchants.name as merchant_name', 'merchants.phone as merchant_phone')
            ->paginate(6);

        return view('pages.index')->with('rens', $rens);
    }
}
