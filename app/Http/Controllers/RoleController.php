<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();

        if(($user->role_id) == 1) {
            $rols = DB::table('roles')->get();

            return view('backend.role.index')->with('user', $user)->with('rols', $rols);
        }
        else {
            return back()->with('status', 'Tidak Punya Akses');
        }
    }

    public function create()
    {
        $user = auth()->user();

        if(($user->role_id) == 1) {
            return view('backend.role.create')->with('user', $user);
        }
        else {
            return back()->with('status', 'Tidak Punya Akses');
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'role' => 'required|string|max:255',
        ]);

        $user = auth()->user();

        $role = new Role;
        $role->name = $request->input('role');

        $role->save();

        return redirect()->route('role')->with('success', 'Wewenang Berhasil Disimpan');
    }

    public function show($id)
    {
        try {
            $rol = Role::where('id', $id)->first();

            return view('backend.role.show')->with('rol', $rol);
        } catch (\Exception $e) {
            return back()->with('error', 'Maaf Data Tidak Sesuai');
        }
    }

    public function edit($id)
    {
        $user = auth()->user();

        if(($user->role_id) == 1) {
            $rol = Role::findOrFail($id);

            return view('backend.role.edit')->with('rol', $rol);
        }
        else {
            return back()->with('status', 'Tidak Punya Akses');
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'role' => 'required|string|max:255',
        ]);

        $role = Role::findOrFail($id);
        $role->name = $request->input('role');
        $role->save();

        return redirect()->route('role')->with('success', 'Wewenang Berhasil Diubah');
    }

    public function destroy($id)
    {
        try {
            $rol = Role::findOrFail($id);
            $rol->delete();

            return redirect()->route('role')->with('success', 'Wewenang Berhasil Dihapus');
        } catch (\Exception $e) {
            return back()->with('error', 'Maaf Data Tidak Sesuai');
        }
    }
}
