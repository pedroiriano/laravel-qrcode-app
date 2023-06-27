<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Merchant;

class MerchantController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();

        if(($user->role_id) == 1) {
            $mers = DB::table('merchants')->get();

            return view('backend.merchant.index')->with('user', $user)->with('mers', $mers);
        }
        else {
            return back()->with('status', 'Tidak Punya Akses');
        }
    }

    public function create()
    {
        $user = auth()->user();

        if(($user->role_id) == 1) {
            return view('backend.merchant.create')->with('user', $user);
        }
        else {
            return back()->with('status', 'Tidak Punya Akses');
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'retribution' => 'required',
        ]);

        $user = auth()->user();

        if (($request->input('merchant') === 'Kios') && ($request->input('area') === 'n/a'))
        {
            return back()->with('status', 'Maaf Pilih Luas');
        }
        else
        {
            if ((DB::table('merchants')
            ->where('merchant_type', $request->input('merchant'))
            ->where('area', $request->input('area'))
            ->first()) === NULL)
            {
                $merchant = new Merchant;
                $merchant->merchant_type = $request->input('merchant');
                $merchant->area = $request->input('area');
                $merchant->retribution = $request->input('retribution');
            }
            else
            {
                return back()->with('status', 'Maaf Data Sudah Ada');
            }
        }

        $merchant->save();

        return redirect()->route('merchant')->with('success', 'Pasar Berhasil Disimpan');
    }

    public function show($id)
    {
        try {
            $mer = Merchant::where('id', $id)->first();

            return view('backend.merchant.show')->with('mer', $mer);
        } catch (\Exception $e) {
            return back()->with('error', 'Maaf Data Tidak Sesuai');
        }
    }

    public function edit($id)
    {
        $user = auth()->user();

        if(($user->role_id) == 1) {
            $mer = Merchant::findOrFail($id);

            return view('backend.merchant.edit')->with('mer', $mer);
        }
        else {
            return back()->with('status', 'Tidak Punya Akses');
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'retribution' => 'required',
        ]);

        if (($request->input('merchant') === 'Kios') && ($request->input('area') === 'n/a'))
        {
            return back()->with('status', 'Maaf Pilih Luas');
        }
        else
        {
            if ((DB::table('merchants')
            ->where('merchant_type', $request->input('merchant'))
            ->where('area', $request->input('area'))
            ->first()) === NULL)
            {
                $merchant = Merchant::findOrFail($id);
                $merchant->merchant_type = $request->input('merchant');
                $merchant->area = $request->input('area');
                $merchant->retribution = $request->input('retribution');
            }
            else
            {
                return back()->with('status', 'Maaf Data Sudah Ada');
            }
        }

        $merchant->save();

        return redirect()->route('merchant')->with('success', 'Pasar Berhasil Diubah');
    }

    public function destroy($id)
    {
        try {
            $mer = Merchant::findOrFail($id);
            $mer->delete();

            return redirect()->route('merchant')->with('success', 'Pasar Berhasil Dihapus');
        } catch (\Exception $e) {
            return back()->with('error', 'Maaf Data Tidak Sesuai');
        }
    }
}
