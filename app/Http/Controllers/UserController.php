<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();

        if(($user->role_id) == 1) {
            $uses = DB::table('users')
                ->leftJoin('roles', 'users.role_id', '=', 'roles.id')
                ->select('users.*', 'roles.name as role_name')
                ->get();

            return view('backend.user.index')->with('user', $user)->with('uses', $uses);
        }
        else {
            return back()->with('status', 'Tidak Punya Akses');
        }
    }

    public function create()
    {
        $user = auth()->user();

        if(($user->role_id) == 1) {
            $rols = DB::table('roles')->get();

            return view('backend.user.create')->with('user', $user)->with('rols', $rols);
        }
        else {
            return back()->with('status', 'Tidak Punya Akses');
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'user' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:9|confirmed',
        ]);

        $user = new User;
        $user->name = $request->input('user');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->role_id = $request->input('role');
        $user->status = $request->input('status');

        $user->save();

        return redirect()->route('user')->with('success', 'Pengguna Berhasil Disimpan');
    }

    public function show($id)
    {
        try {
            $user = auth()->user();

            $use = DB::table('users')
            ->leftJoin('roles', 'users.role_id', '=', 'roles.id')
            ->where('users.id', $id)
            ->select('users.*', 'roles.name as role_name')
            ->first();

            return view('backend.user.show')->with('user', $user)->with('use', $use);
        } catch (\Exception $e) {
            return back()->with('error', 'Maaf Data Tidak Sesuai');
        }
    }

    public function edit($id)
    {
        $user = auth()->user();

        if(($user->role_id) == 1) {
            $use = User::findOrFail($id);
            $rols = DB::table('roles')->get();

            return view('backend.user.edit')->with('user', $user)->with('use', $use)->with('rols', $rols);
        }
        else if(($user->role_id) == 2) {
            $use = User::findOrFail($id);
            if ($user->id == $use->id) {
                $rols = DB::table('roles')->get();

                return view('backend.user.edit')->with('user', $user)->with('use', $use)->with('rols', $rols);
            } else {
                return back()->with('status', 'Tidak Punya Akses');
            }
        }
        else {
            return back()->with('status', 'Tidak Punya Akses');
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'user' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
        ]);

        $user = auth()->user();

        $account = User::findOrFail($id);
        $account->name = $request->input('user');
        $account->email = $request->input('email');
        if ($request->input('password') <> NULL) {
            $account->password = Hash::make($request->input('password'));
        }
        if ($request->input('role') <> NULL) {
            $account->role_id = $request->input('role');
        }
        if ($request->input('status') <> NULL) {
            $account->status = $request->input('status');
        }
        $account->save();

        if(($user->role_id) == 1) {
            return redirect()->route('user')->with('success', 'Pengguna Berhasil Diubah');
        }
        else if(($user->role_id) == 2) {
            return back()->with('success', 'Pengguna Berhasil Diubah');
        }
        else {
            return back()->with('status', 'Tidak Punya Akses');
        }
    }

    public function destroy($id)
    {
        try {
            $use = User::findOrFail($id);
            $use->delete();

            return redirect()->route('user')->with('success', 'Pengguna Berhasil Dihapus');
        } catch (\Exception $e) {
            return back()->with('error', 'Maaf Data Tidak Sesuai');
        }
    }
}
