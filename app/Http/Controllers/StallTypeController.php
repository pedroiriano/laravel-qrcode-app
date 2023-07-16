<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\StallType;

class StallTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();

        if(($user->role_id) == 1) {
            $stys = DB::table('stall_types')->get();

            return view('backend.stall_type.index')->with('user', $user)->with('stys', $stys);
        }
        else {
            return back()->with('status', 'Tidak Punya Akses');
        }
    }

    public function create()
    {
        $user = auth()->user();

        if(($user->role_id) == 1) {
            return view('backend.stall_type.create')->with('user', $user);
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

        if (($request->input('stall_type') === 'Kios') && ($request->input('area') === 'n/a'))
        {
            return back()->with('status', 'Maaf Pilih Luas');
        }
        else
        {
            if ((DB::table('stall_types')
            ->where('stall_type', $request->input('stall_type'))
            ->where('area', $request->input('area'))
            ->first()) === NULL)
            {
                $sty = new StallType;
                $sty->stall_type = $request->input('stall_type');
                $sty->area = $request->input('area');
                $sty->retribution = $request->input('retribution');
            }
            else
            {
                return back()->with('status', 'Maaf Data Sudah Ada');
            }
        }

        $sty->save();

        return redirect()->route('stall-type')->with('success', 'Jenis Kios/Los Berhasil Disimpan');
    }

    public function show($id)
    {
        try {
            $sty = StallType::where('id', $id)->first();

            return view('backend.stall_type.show')->with('sty', $sty);
        } catch (\Exception $e) {
            return back()->with('error', 'Maaf Data Tidak Sesuai');
        }
    }

    public function edit($id)
    {
        $user = auth()->user();

        if(($user->role_id) == 1) {
            $sty = StallType::findOrFail($id);

            return view('backend.stall_type.edit')->with('sty', $sty);
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
            if ((DB::table('stall_types')
            ->where('stall_type', $request->input('stall_type'))
            ->where('area', $request->input('area'))
            ->first()) === NULL)
            {
                $sty = StallType::findOrFail($id);
                $sty->stall_type = $request->input('stall_type');
                $sty->area = $request->input('area');
                $sty->retribution = $request->input('retribution');
            }
            else
            {
                if ((DB::table('stall_types')
                ->where('stall_type', $request->input('stall_type'))
                ->where('area', $request->input('area'))
                ->where('retribution', $request->input('retribution'))
                ->first()) === NULL)
                {
                    $sty = StallType::findOrFail($id);
                    $sty->stall_type = $request->input('stall_type');
                    $sty->area = $request->input('area');
                    $sty->retribution = $request->input('retribution');
                }
                else
                {
                    return back()->with('status', 'Maaf Data Sudah Ada');
                }
            }
        }

        $sty->save();

        return redirect()->route('stall-type')->with('success', 'Jenis Kios/Los Berhasil Diubah');
    }

    public function destroy($id)
    {
        try {
            $sty = StallType::findOrFail($id);
            $sty->delete();

            return redirect()->route('stall-type')->with('success', 'Jenis Kios/Los Berhasil Dihapus');
        } catch (\Exception $e) {
            return back()->with('error', 'Maaf Data Tidak Sesuai');
        }
    }
}
