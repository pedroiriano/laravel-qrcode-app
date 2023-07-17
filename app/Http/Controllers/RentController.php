<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Stall;
use App\Models\Merchant;
use App\Models\Rent;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Carbon;

class RentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();

        if(($user->role_id) == 1) {
            $rens = DB::table('rents')
                ->join('stalls', 'rents.stall_id', '=', 'stalls.id')
                ->join('merchants', 'rents.merchant_id', '=', 'merchants.id')
                ->leftJoin('stall_types', 'stalls.stall_type_id', '=', 'stall_types.id')
                ->select('rents.*', 'stalls.stall_type_id', 'stalls.location', 'stalls.area as stall_area', 'merchants.identity as merchant_identity', 'merchants.name as merchant_name', 'merchants.phone as merchant_phone', 'stall_types.stall_type')
                ->get();

            return view('backend.rent.index')->with('user', $user)->with('rens', $rens);
        }
        else {
            return back()->with('status', 'Tidak Punya Akses');
        }
    }

    public function create()
    {
        $user = auth()->user();

        if(($user->role_id) == 1) {
            $stas = DB::table('stalls')
                ->join('stall_types', 'stalls.stall_type_id', '=', 'stall_types.id')
                ->select(DB::raw("CONCAT(stall_type, ' ', location, ' Luas: ', stalls.area, ' m2', ' Biaya: ', stalls.cost, '/tahun') AS stall_info"), 'stalls.id')
                ->pluck('stall_info', 'stalls.id');

            $mers = Merchant::select(
                DB::raw("CONCAT(identity, ' ', name) AS merchant_info"), 'id')
                ->pluck('merchant_info', 'id');

            return view('backend.rent.create')->with('user', $user)->with('stas', $stas)->with('mers', $mers);
        }
        else {
            return back()->with('status', 'Tidak Punya Akses');
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'trade_type' => 'required',
            'pay_cost' => 'required',
            'start' => 'required',
        ]);

        $user = auth()->user();

        $rent = new Rent;
        $rent->stall_id = $request->input('stall');
        $rent->merchant_id = $request->input('merchant');
        $rent->trade_type = $request->input('trade_type');
        $cost = Stall::select('cost')->where('id', $request->input('stall'))->first()->cost;
        $total_cost = $cost * $request->input('pay_cost');
        $rent->pay_cost = $total_cost;
        $rent->start = $request->input('start');
        $rent->end = Carbon::parse($rent->start)->addYear($request->input('pay_cost'));;
        if (($request->input('pay_cost') === NULL) or ($request->input('pay_cost') === 0))
        {
            $rent->status = 'Tidak Aktif';
        }
        else
        {
            $rent->status = 'Aktif';
        }

        $rent->save();

        return redirect()->route('rent')->with('success', 'Sewa Berhasil Disimpan');
    }

    public function show($id)
    {
        try {
            $ren = DB::table('rents')
                ->join('stalls', 'rents.stall_id', '=', 'stalls.id')
                ->join('merchants', 'rents.merchant_id', '=', 'merchants.id')
                ->leftJoin('stall_types', 'stalls.stall_type_id', '=', 'stall_types.id')
                ->select('rents.*', 'stalls.stall_type_id', 'stalls.location', 'stalls.area as stall_area', 'merchants.identity as merchant_identity', 'merchants.name as merchant_name', 'merchants.phone as merchant_phone', 'stall_types.stall_type', 'stall_types.retribution as stall_retribution')
                ->first();

            return view('backend.rent.show')->with('ren', $ren);
        } catch (\Exception $e) {
            return back()->with('error', 'Maaf Data Tidak Sesuai');
        }
    }

    public function edit($id)
    {
        $user = auth()->user();

        if(($user->role_id) == 1) {
            $ren = Rent::findOrFail($id);

            $stas = Stall::select(
                DB::raw("CONCAT(stall_type, ' ', area) AS stall_info"), 'id')
                ->pluck('stall_info', 'id');

            $mers = Merchant::select(
                DB::raw("CONCAT(identity, ' ', name) AS merchant_info"), 'id')
                ->pluck('merchant_info', 'id');

            return view('backend.rent.edit')->with('ren', $ren)->with('stas', $stas)->with('mers', $mers);
        }
        else {
            return back()->with('status', 'Tidak Punya Akses');
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'area' => 'required',
            'location' => 'required',
            'trade_type' => 'required',
        ]);

        if ((DB::table('rents')->select('stall_id')->where('id', $id)->first()->stall_id == $request->input('stall')) && (DB::table('rents')->select('merchant_id')->where('id', $id)->first()->merchant_id == $request->input('merchant')) && (DB::table('rents')->select('location')->where('id', $id)->first()->location == $request->input('location')))
        {
            $rent = Rent::findOrFail($id);
            $rent->stall_id = $request->input('stall');
            $rent->merchant_id = $request->input('merchant');
            $rent->area = $request->input('area');
            $rent->location = $request->input('location');
            $rent->trade_type = $request->input('trade_type');
            $rent->status = $request->input('status');
        }
        else
        {
            if ((DB::table('rents')
            ->where('stall_id', $request->input('stall'))
            ->where('merchant_id', $request->input('merchant'))
            ->where('location', $request->input('location'))
            ->first()) === NULL)
            {
                $rent = Rent::findOrFail($id);
                $rent->stall_id = $request->input('stall');
                $rent->merchant_id = $request->input('merchant');
                $rent->area = $request->input('area');
                $rent->location = $request->input('location');
                $rent->trade_type = $request->input('trade_type');
                $rent->status = $request->input('status');
            }
            else
            {
                return back()->with('status', 'Maaf Data Sudah Ada');
            }
        }

        $rent->save();

        return redirect()->route('rent')->with('success', 'Sewa Berhasil Diubah');
    }

    public function destroy($id)
    {
        try {
            $ren = Rent::findOrFail($id);
            $ren->delete();

            return redirect()->route('rent')->with('success', 'Sewa Berhasil Dihapus');
        } catch (\Exception $e) {
            return back()->with('error', 'Maaf Data Tidak Sesuai');
        }
    }
}
