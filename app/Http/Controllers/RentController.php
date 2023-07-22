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
                ->where('stalls.occupy', 'Tidak')
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
            // 'pay_cost' => 'required',
            'start' => 'required',
        ]);

        $user = auth()->user();

        $rent = new Rent;
        $rent->stall_id = $request->input('stall');
        $rent->merchant_id = $request->input('merchant');
        $rent->trade_type = $request->input('trade_type');
        $cost = Stall::select('cost')->where('id', $request->input('stall'))->first()->cost;
        // $total_cost = $cost * $request->input('pay_cost');
        // $rent->pay_cost = $total_cost;
        $rent->start = $request->input('start');
        $rent->end = Carbon::parse($rent->start)->addYear(1);
        // $rent->end = Carbon::parse($rent->start)->addYear($request->input('pay_cost'));
        // if (($request->input('pay_cost') === NULL) or ($request->input('pay_cost') === 0))
        // {
        //     $rent->status = 'Tidak Aktif';
        // }
        // else
        // {
        //     $rent->status = 'Aktif';
        // }

        if (($request->input('start') === NULL) or ($request->input('start') === 0))
        {
            $rent->pay_cost = 0;
            $rent->status = 'Tidak Aktif';

            $stall = Stall::findOrFail($request->input('stall'));
            $stall->occupy = 'Tidak';
            $stall->save();
        }
        else
        {
            $rent->pay_cost = $cost;
            $rent->status = 'Aktif';

            $stall = Stall::findOrFail($request->input('stall'));
            $stall->occupy = 'Ya';
            $stall->save();
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
                ->select('rents.*', 'stalls.stall_type_id', 'stalls.location', 'stalls.area as stall_area', 'stalls.cost', 'stalls.qr', 'stalls.occupy', 'merchants.identity as merchant_identity', 'merchants.name as merchant_name', 'merchants.address as merchant_address', 'merchants.phone as merchant_phone', 'merchants.photo as merchant_photo', 'stall_types.stall_type', 'stall_types.area as stall_type_area', 'stall_types.retribution as stall_retribution')
                ->where('rents.id', $id)
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

            $stas = DB::table('stalls')
                ->join('stall_types', 'stalls.stall_type_id', '=', 'stall_types.id')
                ->select(DB::raw("CONCAT(stall_type, ' ', location, ' Luas: ', stalls.area, ' m2', ' Biaya: ', stalls.cost, '/tahun') AS stall_info"), 'stalls.id')
                ->where('occupy', 'Tidak')
                ->orWhere('stalls.id', $ren->stall_id)
                ->pluck('stall_info', 'stalls.id');

            $mers = Merchant::select(
                DB::raw("CONCAT(identity, ' ', name) AS merchant_info"), 'id')
                ->pluck('merchant_info', 'id');

            return view('backend.rent.edit')->with('user', $user)->with('stas', $stas)->with('mers', $mers)->with('ren', $ren);
        }
        else {
            return back()->with('status', 'Tidak Punya Akses');
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'trade_type' => 'required',
            // 'pay_cost' => 'required',
            'start' => 'required',
        ]);

        if ((DB::table('rents')->select('stall_id')->where('id', $id)->first()->stall_id == $request->input('stall')) && (DB::table('rents')->select('merchant_id')->where('id', $id)->first()->merchant_id == $request->input('merchant')))
        {
            $rent = Rent::findOrFail($id);
            $rent->stall_id = $request->input('stall');
            $rent->merchant_id = $request->input('merchant');
            $rent->trade_type = $request->input('trade_type');
            $cost = Stall::select('cost')->where('id', $request->input('stall'))->first()->cost;
            $rent->start = $request->input('start');
            $rent->end = Carbon::parse($rent->start)->addYear(1);

            if (($request->input('start') === NULL) or ($request->input('start') === 0))
            {
                $rent->pay_cost = 0;
                $rent->status = 'Tidak Aktif';

                $stall = Stall::findOrFail($request->input('stall'));
                $stall->occupy = 'Tidak';
                $stall->save();
            }
            else
            {
                $rent->pay_cost = $cost;
                $rent->status = 'Aktif';

                $stall = Stall::findOrFail($request->input('stall'));
                $stall->occupy = 'Ya';
                $stall->save();
            }
        }
        else
        {
            if ((DB::table('rents')
            ->where('stall_id', $request->input('stall'))
            ->where('merchant_id', $request->input('merchant'))
            ->first()) === NULL)
            {
                if ((DB::table('rents')->select('stall_id')->where('id', $id)->first()->stall_id == $request->input('stall')))
                {
                    $rent = Rent::findOrFail($id);
                    $rent->stall_id = $request->input('stall');
                    $rent->merchant_id = $request->input('merchant');
                    $rent->trade_type = $request->input('trade_type');
                    $cost = Stall::select('cost')->where('id', $request->input('stall'))->first()->cost;
                    $rent->start = $request->input('start');
                    $rent->end = Carbon::parse($rent->start)->addYear(1);

                    if (($request->input('start') === NULL) or ($request->input('start') === 0))
                    {
                        $rent->pay_cost = 0;
                        $rent->status = 'Tidak Aktif';

                        $stall = Stall::findOrFail($request->input('stall'));
                        $stall->occupy = 'Tidak';
                        $stall->save();
                    }
                    else
                    {
                        $rent->pay_cost = $cost;
                        $rent->status = 'Aktif';

                        $stall = Stall::findOrFail($request->input('stall'));
                        $stall->occupy = 'Ya';
                        $stall->save();
                    }
                }
                else
                {
                    $rent = Rent::findOrFail($id);
                    $rent->stall_id = $request->input('stall');
                    $rent->merchant_id = $request->input('merchant');
                    $rent->trade_type = $request->input('trade_type');
                    $cost = Stall::select('cost')->where('id', $request->input('stall'))->first()->cost;
                    $rent->start = $request->input('start');
                    $rent->end = Carbon::parse($rent->start)->addYear(1);

                    if (($request->input('start') === NULL) or ($request->input('start') === 0))
                    {
                        $rent->pay_cost = 0;
                        $rent->status = 'Tidak Aktif';

                        $stall = Stall::findOrFail($request->input('stall'));
                        $stall->occupy = 'Tidak';
                        $stall->save();

                        $stall_old_id = Rent::select('stall_id')->where('id', $id)->first()->stall_id;
                        $stall_old = Stall::findOrFail($stall_old_id);
                        $stall_old->occupy = 'Tidak';
                        $stall_old->save();
                    }
                    else
                    {
                        $rent->pay_cost = $cost;
                        $rent->status = 'Aktif';

                        $stall = Stall::findOrFail($request->input('stall'));
                        $stall->occupy = 'Ya';
                        $stall->save();

                        $stall_old_id = Rent::select('stall_id')->where('id', $id)->first()->stall_id;
                        $stall_old = Stall::findOrFail($stall_old_id);
                        $stall_old->occupy = 'Tidak';
                        $stall_old->save();
                    }
                }
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
            $ren_stall_id = Rent::select('stall_id')->where('id', $id)->first()->stall_id;
            $ren_stall = Stall::findOrFail($ren_stall_id);
            $ren_stall->occupy = 'Tidak';
            $ren_stall->save();

            $ren = Rent::findOrFail($id);
            $ren->delete();

            return redirect()->route('rent')->with('success', 'Sewa Berhasil Dihapus');
        } catch (\Exception $e) {
            return back()->with('error', 'Maaf Data Tidak Sesuai');
        }
    }
}
