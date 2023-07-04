<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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
            'identity' => 'required|min:16|max:16|unique:merchants',
            'phone' => 'required|min:9|max:15|unique:merchants',
            'photo' => 'image|mimes:jpg,jpeg,png,gif,bmp|max:150000',
        ]);

        $user = auth()->user();

        if($request->hasFile('photo')) {
            $photoNameWithExt = $request->file('photo')->getClientOriginalName();
            $photoName = pathinfo($photoNameWithExt, PATHINFO_FILENAME);
            $photoName = $request->input('name');
            $convertPhotoName = Str::lower($photoName);
            $collectionConvertPhotoName = Str::of($convertPhotoName)->explode(' ');
            $collectionConvertPhotoName = $collectionConvertPhotoName->implode('-');
            $photoExt = $request->file('photo')->getClientOriginalExtension();
            $photoNameSaved = $collectionConvertPhotoName.'-'.time().'.'.$photoExt;
            $photoPath = $request->file('photo')->storeAs('public/photos', $photoNameSaved);
        }
        else {
            return back()->with('error', 'Unggah Foto Gagal');
        }

        if ((DB::table('merchants')
        ->where('identity', $request->input('identity'))
        ->orWhere('phone', $request->input('phone'))
        ->first()) === NULL)
        {
            $merchant = new Merchant;
            $merchant->identity = $request->input('identity');
            $merchant->name = $request->input('name');
            $merchant->address = $request->input('address');
            $merchant->phone = $request->input('phone');
            $merchant->photo = $photoNameSaved;
        }
        else
        {
            return back()->with('status', 'Maaf Data Sudah Ada');
        }

        $merchant->save();

        return redirect()->route('merchant')->with('success', 'Pedagang Berhasil Disimpan');
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
            'identity' => 'required|min:16|max:16',
            'phone' => 'required|min:9|max:15',
            'photo' => 'image|mimes:jpg,jpeg,png,gif,bmp|max:150000',
        ]);

        if($request->hasFile('photo')) {
            $photoNameWithExt = $request->file('photo')->getClientOriginalName();
            $photoName = pathinfo($photoNameWithExt, PATHINFO_FILENAME);
            $photoName = $request->input('name');
            $convertPhotoName = Str::lower($photoName);
            $collectionConvertPhotoName = Str::of($convertPhotoName)->explode(' ');
            $collectionConvertPhotoName = $collectionConvertPhotoName->implode('-');
            $photoExt = $request->file('photo')->getClientOriginalExtension();
            $photoNameSaved = $collectionConvertPhotoName.'-'.time().'.'.$photoExt;
            $photoPath = $request->file('photo')->storeAs('public/photos', $photoNameSaved);
        }
        else {

        }

        if (DB::table('merchants')->select('identity')->where('id', $id)->first()->identity == $request->input('identity'))
        {
            $merchant = Merchant::findOrFail($id);
            $merchant->identity = $request->input('identity');
            $merchant->name = $request->input('name');
            $merchant->address = $request->input('address');
            $merchant->phone = $request->input('phone');
            if($request->hasFile('photo')) {
                $oldPhoto = $merchant->photo;
                Storage::delete('public/photos/'.$oldPhoto);
                $merchant->photo = $photoNameSaved;
            }
            else {
                $oldPhoto = $merchant->photo;
                $merchant->photo = $oldPhoto;
            }
        }
        else
        {
            if ((DB::table('merchants')
            ->where('identity', $request->input('identity'))
            ->orWhere('phone', $request->input('phone'))
            ->first()) === NULL)
            {
                $merchant = Merchant::findOrFail($id);
                $merchant->identity = $request->input('identity');
                $merchant->name = $request->input('name');
                $merchant->address = $request->input('address');
                $merchant->phone = $request->input('phone');
                if($request->hasFile('photo')) {
                    $oldPhoto = $merchant->photo;
                    Storage::delete('public/photos/'.$oldPhoto);
                    $merchant->photo = $photoNameSaved;
                }
                else {
                    $oldPhoto = $merchant->photo;
                    $merchant->photo = $oldPhoto;
                }
            }
            else
            {
                return back()->with('status', 'Maaf Data Sudah Ada');
            }
        }

        $merchant->save();

        return redirect()->route('merchant')->with('success', 'Pedagang Berhasil Diubah');
    }

    public function destroy($id)
    {
        try {
            $mer = Merchant::findOrFail($id);
            $mer->delete();

            return redirect()->route('merchant')->with('success', 'Pedagang Berhasil Dihapus');
        } catch (\Exception $e) {
            return back()->with('error', 'Maaf Data Tidak Sesuai');
        }
    }
}
