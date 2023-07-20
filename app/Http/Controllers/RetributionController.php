<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Stall;
use App\Models\Merchant;
use App\Models\Rent;
use Illuminate\Support\Carbon;

class RetributionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();

        if(($user->role_id) == 1) {
            $rets = DB::table('retributions')
                ->join('rents', 'retributions.rent_id', '=', 'rents.id')
                ->join('stalls', 'rents.stall_id', '=', 'stalls.id')
                ->join('merchants', 'rents.merchant_id', '=', 'merchants.id')
                ->leftJoin('stall_types', 'stalls.stall_type_id', '=', 'stall_types.id')
                ->select('retributions.*', 'rents.trade_type', 'rents.start', 'rents.status', 'stalls.stall_type_id', 'stalls.location', 'stalls.area as stall_area', 'merchants.identity as merchant_identity', 'merchants.name as merchant_name', 'merchants.phone as merchant_phone', 'stall_types.stall_type', 'stall_types.retribution')
                ->get();

            return view('backend.rent.index')->with('user', $user)->with('rets', $rets);
        }
        else {
            return back()->with('status', 'Tidak Punya Akses');
        }
    }
}
