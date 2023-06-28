<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Stall;

class StallController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();

        if(($user->role_id) == 1) {
            $stas = DB::table('stalls')->get();

            return view('backend.stall.index')->with('user', $user)->with('stas', $stas);
        }
        else {
            return back()->with('status', 'Tidak Punya Akses');
        }
    }

    public function create()
    {
        $user = auth()->user();

        if(($user->role_id) == 1) {
            return view('backend.stall.create')->with('user', $user);
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

        if (($request->input('stall') === 'Kios') && ($request->input('area') === 'n/a'))
        {
            return back()->with('status', 'Maaf Pilih Luas');
        }
        else
        {
            if ((DB::table('stalls')
            ->where('stall_type', $request->input('stall'))
            ->where('area', $request->input('area'))
            ->first()) === NULL)
            {
                $stall = new Stall;
                $stall->stall_type = $request->input('stall');
                $stall->area = $request->input('area');
                $stall->retribution = $request->input('retribution');
            }
            else
            {
                return back()->with('status', 'Maaf Data Sudah Ada');
            }
        }

        $stall->save();

        return redirect()->route('stall')->with('success', 'Kios/Los Berhasil Disimpan');
    }

    public function show($id)
    {
        try {
            $sta = Stall::where('id', $id)->first();

            return view('backend.stall.show')->with('sta', $sta);
        } catch (\Exception $e) {
            return back()->with('error', 'Maaf Data Tidak Sesuai');
        }
    }

    public function edit($id)
    {
        $user = auth()->user();

        if(($user->role_id) == 1) {
            $sta = Stall::findOrFail($id);

            return view('backend.stall.edit')->with('sta', $sta);
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

        if (($request->input('stall') === 'Kios') && ($request->input('area') === 'n/a'))
        {
            return back()->with('status', 'Maaf Pilih Luas');
        }
        else
        {
            if ((DB::table('stalls')
            ->where('stall_type', $request->input('stall'))
            ->where('area', $request->input('area'))
            ->first()) === NULL)
            {
                $stall = Stall::findOrFail($id);
                $stall->stall_type = $request->input('stall');
                $stall->area = $request->input('area');
                $stall->retribution = $request->input('retribution');
            }
            else
            {
                return back()->with('status', 'Maaf Data Sudah Ada');
            }
        }

        $stall->save();

        return redirect()->route('stall')->with('success', 'Kios/Los Berhasil Diubah');
    }

    public function destroy($id)
    {
        try {
            $sta = Stall::findOrFail($id);
            $sta->delete();

            return redirect()->route('stall')->with('success', 'Kios/Los Berhasil Dihapus');
        } catch (\Exception $e) {
            return back()->with('error', 'Maaf Data Tidak Sesuai');
        }
    }
}
