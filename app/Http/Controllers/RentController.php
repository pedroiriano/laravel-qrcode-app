<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Stall;
use App\Models\Merchant;
use App\Models\Rent;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
                ->select('rents.*', 'stalls.stall_type', 'stalls.area as stall_area', 'merchants.identity as merchant_identity', 'merchants.name as merchant_name', 'merchants.phone as merchant_phone')
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
            $stas = Stall::select(
                DB::raw("CONCAT(stall_type, ' ', area) AS stall_info"), 'id')
                ->pluck('stall_info', 'id');

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
            'area' => 'required',
            'location' => 'required',
        ]);

        $user = auth()->user();

        $image = QrCode::format('png')->size(200)->errorCorrection('H')->generate('https://pasarkemiridepok.pepeve.id/rent/'.$request['merchant']);

        $image_name = 'img-'.time().'.png';
        $image_path = '/img/qr-code/';
        $output_image = $image_path.$image_name;
        Storage::disk('public')->put($output_image, $image);

        $rent = new Rent;
        $rent->stall_id = $request->input('stall');
        $rent->merchant_id = $request->input('merchant');
        $rent->area = $request->input('area');
        $rent->location = $request->input('location');
        $rent->trade_type = $request->input('trade_type');
        $rent->qr = $image_name;
        $rent->status = $request->input('status');

        $rent->save();

        return redirect()->route('rent')->with('success', 'Sewa Berhasil Disimpan');
    }

    public function show($id)
    {
        try {
            $ren = DB::table('rents')
                ->join('stalls', 'rents.stall_id', '=', 'stalls.id')
                ->join('merchants', 'rents.merchant_id', '=', 'merchants.id')
                ->select('rents.*', 'stalls.stall_type', 'stalls.area as stall_area', 'stalls.retribution as stall_retribution', 'merchants.identity as merchant_identity', 'merchants.name as merchant_name', 'merchants.phone as merchant_phone')
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
