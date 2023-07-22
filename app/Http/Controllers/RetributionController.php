<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\StallType;
use App\Models\Stall;
use App\Models\Merchant;
use App\Models\Rent;
use App\Models\Retribution;
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

            return view('backend.retribution.index')->with('user', $user)->with('rets', $rets);
        }
        else {
            return back()->with('status', 'Tidak Punya Akses');
        }
    }

    public function create()
    {
        $user = auth()->user();

        if(($user->role_id) == 1) {
            $rens = DB::table('rents')
                ->join('stalls', 'rents.stall_id', '=', 'stalls.id')
                ->join('merchants', 'rents.merchant_id', '=', 'merchants.id')
                ->leftJoin('stall_types', 'stalls.stall_type_id', '=', 'stall_types.id')
                ->select(DB::raw("CONCAT(stall_types.stall_type, ' ', stalls.location, ' ', merchants.name) AS rent_info"), 'rents.id')
                ->where('rents.status', 'Aktif')
                ->pluck('rent_info', 'rents.id');

            return view('backend.retribution.create')->with('user', $user)->with('rens', $rens);
        }
        else {
            return back()->with('status', 'Tidak Punya Akses');
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'amount' => 'required',
            'retribution_date' => 'required',
        ]);

        $user = auth()->user();

        $start = Rent::where('id', $request->input('rent'))->first()->start;
        $start = Carbon::parse($start);
        $end = Carbon::parse($request->input('retribution_date'));
        $difference = $start->diffInDays($end);

        $stall_id = Rent::where('id', $request->input('rent'))->first()->stall_id;
        $stall_type_id = Stall::where('id', $stall_id)->first()->stall_type_id;
        $ret = StallType::where('id', $stall_type_id)->first()->retribution;
        $due = $difference * $ret;
        // dd($due);
        $retribution = new Retribution;
        $retribution->rent_id = $request->input('rent');
        $retribution->pay_date = $request->input('retribution_date');
        $retribution->amount = $request->input('amount');
        $due_amount = $due - $request->input('amount');
        $retribution->due_amount = $due_amount;

        // if (($request->input('start') === NULL) or ($request->input('start') === 0))
        // {
        //     $retribution->pay_cost = 0;
        //     $retribution->status = 'Tidak Aktif';

        //     $stall = Stall::findOrFail($request->input('stall'));
        //     $stall->occupy = 'Tidak';
        //     $stall->save();
        // }
        // else
        // {
        //     $retribution->pay_cost = $cost;
        //     $retribution->status = 'Aktif';

        //     $stall = Stall::findOrFail($request->input('stall'));
        //     $stall->occupy = 'Ya';
        //     $stall->save();
        // }

        $retribution->save();

        return redirect()->route('retribution')->with('success', 'Retribusi Berhasil Disimpan');
    }

    public function getDueAmount(Request $request)
    {
        $rentId = $request->input('rent_id');

        $ret = Retribution::where('rent_id', $rentId)->latest('created_at')->first();

        if ($ret) {
            $dueAmount = $ret->due_amount;
            return response()->json(['due_amount' => $dueAmount]);
        } else {
            return response()->json(['due_amount' => 0]);
        }
    }
}
