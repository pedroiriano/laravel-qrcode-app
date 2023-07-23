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
                ->orderBy('id', 'desc')
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
        $rentId = $request->input('rent');

        $existingRetribution = Retribution::where('rent_id', $rentId)->first();

        $start = Rent::where('id', $rentId)->value('start');
        $start = Carbon::parse($start);
        $end = Carbon::now();
        $difference = $start->diffInDays($end);

        $stallId = Rent::where('id', $rentId)->value('stall_id');
        $stallTypeId = Stall::where('id', $stallId)->value('stall_type_id');
        $retributionAmount = StallType::where('id', $stallTypeId)->value('retribution');
        $dueAmount = $difference * $retributionAmount;

        if ($existingRetribution === null) {
            $retribution = new Retribution;
            $retribution->rent_id = $rentId;
            $retribution->pay_date = $request->input('retribution_date');
            $retribution->amount = $request->input('amount');
            $retribution->due_amount = $dueAmount - $request->input('amount');
        } else {
            $sumAmount = Retribution::where('rent_id', $rentId)->sum('amount');
            $currentDueAmount = $dueAmount - ($sumAmount + $request->input('amount'));

            $retribution = new Retribution;
            $retribution->rent_id = $rentId;
            $retribution->pay_date = $request->input('retribution_date');
            $retribution->amount = $request->input('amount');
            $retribution->due_amount = $currentDueAmount;
        }

        $retribution->save();

        return redirect()->route('retribution')->with('success', 'Retribusi Berhasil Disimpan');
    }

    public function destroy($id)
    {
        try {
            $ret = Retribution::findOrFail($id);
            $ret->delete();

            return redirect()->route('retribution')->with('success', 'Retribusi Berhasil Dihapus');
        } catch (\Exception $e) {
            return back()->with('error', 'Maaf Data Tidak Sesuai');
        }
    }

    public function getDueAmount(Request $request)
    {
        $rentId = $request->input('rent_id');

        $existingRetribution = Retribution::where('rent_id', $rentId)->first();
        $sumAmount = Retribution::where('rent_id', $rentId)->sum('amount');

        $start = Rent::where('id', $rentId)->first()->start;
        $start = Carbon::parse($start);
        $end = Carbon::now();
        $difference = $start->diffInDays($end);

        $stall_id = Rent::where('id', $rentId)->first()->stall_id;
        $stall_type_id = Stall::where('id', $stall_id)->first()->stall_type_id;
        $retribution = StallType::where('id', $stall_type_id)->first()->retribution;
        $due = $difference * $retribution;

        if ($existingRetribution) {
            $current_due = $due - $sumAmount;
            return response()->json(['due_amount' => $current_due, 'daily_retibution' => $retribution]);
        } else {
            return response()->json(['due_amount' => $due, 'daily_retibution' => $retribution]);
        }
    }
}
