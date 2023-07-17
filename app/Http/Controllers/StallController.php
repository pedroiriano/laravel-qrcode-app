<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Stall;
use App\Models\StallType;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
            $stas = DB::table('stalls')
                ->join('stall_types', 'stalls.stall_type_id', '=', 'stall_types.id')
                ->select('stalls.*', 'stall_types.stall_type', 'stall_types.area as stall_area', 'stall_types.retribution')
                ->get();

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
            $stys = StallType::select(
                DB::raw("CONCAT(stall_type, ' ', area) AS stall_info"), 'id')
                ->pluck('stall_info', 'id');

            return view('backend.stall.create')->with('user', $user)->with('stys', $stys);
        }
        else {
            return back()->with('status', 'Tidak Punya Akses');
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'location' => 'required',
            'area' => 'required',
        ]);

        $type = $request->input('stall');
        $area = $request->input('area');
        $type = StallType::where('id', $type)->first()->stall_type;
        if ($type === 'Kios')
        {
            $cost = 600000 * $area;
        }
        else if ($type === 'Los')
        {
            $cost = 360000 * $area;
        }
        else
        {
            $cost = 0 * $area;
        }

        $user = auth()->user();

        $max_id = Stall::max('id');

        if ($max_id === NULL)
        {
            $image = QrCode::format('png')->size(200)->errorCorrection('H')->generate('https://pasarkemiridepok.pepeve.id/stall/1');
        }
        else
        {
            $max_id = $max_id + 1;
            $image = QrCode::format('png')->size(200)->errorCorrection('H')->generate('https://pasarkemiridepok.pepeve.id/stall/'.$max_id);
        }

        $image_name = 'img-'.time().'.png';
        $image_path = '/img/qr-code/';
        $output_image = $image_path.$image_name;
        Storage::disk('public')->put($output_image, $image);

        if ((DB::table('stalls')
        ->where('stall_type_id', $request->input('stall'))
        ->where('location', $request->input('location'))
        ->first()) === NULL)
        {
            $stall = new Stall;
            $stall->stall_type_id = $request->input('stall');
            $stall->location = $request->input('location');
            $stall->area = $request->input('area');
            $stall->cost = $cost;
            $stall->qr = $image_name;
            $stall->occupy = 'Tidak';
        }
        else
        {
            return back()->with('status', 'Maaf Data Sudah Ada');
        }

        $stall->save();

        return redirect()->route('stall')->with('success', 'Kios/Los Berhasil Disimpan');
    }

    public function show($id)
    {
        try {
            $sta = DB::table('stalls')
                ->join('stall_types', 'stalls.stall_type_id', '=', 'stall_types.id')
                ->select('stalls.*', 'stall_types.id as stall_id', 'stall_types.stall_type', 'stall_types.area as stall_area', 'stall_types.retribution')
                ->where('stalls.id', $id)
                ->first();

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

            $stys = StallType::select(
                DB::raw("CONCAT(stall_type, ' ', area) AS stall_info"), 'id')
                ->pluck('stall_info', 'id');

            return view('backend.stall.edit')->with('sta', $sta)->with('stys', $stys);
        }
        else {
            return back()->with('status', 'Tidak Punya Akses');
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'location' => 'required',
            'area' => 'required',
        ]);

        $type = $request->input('stall');
        $area = $request->input('area');
        $type = StallType::where('id', $type)->first()->stall_type;
        if ($type === 'Kios')
        {
            $cost = 600000 * $area;
        }
        else if ($type === 'Los')
        {
            $cost = 360000 * $area;
        }
        else
        {
            $cost = 0 * $area;
        }

        if ((DB::table('stalls')->select('stall_type_id')->where('id', $id)->first()->stall_type_id == $request->input('stall')) && (DB::table('stalls')->select('location')->where('id', $id)->first()->location == $request->input('location')))
        {
            $stall = Stall::findOrFail($id);
            $stall->stall_type_id = $request->input('stall');
            $stall->location = $request->input('location');
            $stall->area = $request->input('area');
            $stall->cost = $cost;
        }
        else
        {
            if ((DB::table('stalls')
            ->where('stall_type_id', $request->input('stall'))
            ->where('location', $request->input('location'))
            ->first()) === NULL)
            {
                $stall = Stall::findOrFail($id);
                $stall->stall_type_id = $request->input('stall');
                $stall->location = $request->input('location');
                $stall->area = $request->input('area');
                $stall->cost = $cost;
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
