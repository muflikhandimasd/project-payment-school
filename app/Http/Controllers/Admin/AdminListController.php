<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Petugas;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\DataTables\AdminListDataTable;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\CloudinaryStorage;

class AdminListController extends Controller
{
    public function index(Request $request, AdminListDataTable $datatable)
    {

        $user = User::all();
        $petugas = Petugas::all();

        return view('admin.admin-list.index', compact('user', 'petugas'));
    }

    public function create()
    {
        return view('admin.admin-list.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users',
            'nama_petugas' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $user = User::create([
            'username' => Str::lower($request->username),
            'password' => Hash::make('spp12345678'),
        ]);

        $user->assignRole('admin');

        $image  = $request->file('image');
        $image_url = CloudinaryStorage::upload($image->getRealPath(), $image->getClientOriginalName());

        Petugas::create([
            'user_id' => $user->id,
            'kode_petugas' => 'PTGR' . Str::upper(Str::random(5)),
            'nama_petugas' => $request->nama_petugas,
            'jenis_kelamin' => $request->jenis_kelamin,
            'image' => $image_url
        ]);

        return redirect()->route('admin-list.index');
    }


    public function edit($id)
    {
        // $admin = User::with(['petugas'])->findOrFail($id);
        $petugas = Petugas::findOrFail($id);
        return view('admin.admin-list.edit', compact('petugas'));
    }

    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_petugas' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $employee = new Petugas();
        $file   = $request->file('image');
        $image_url = CloudinaryStorage::replace($employee->image, $file->getRealPath(), $file->getClientOriginalName());
        Petugas::find($id)->update([
            'nama_petugas' => $request->nama_petugas,
            'jenis_kelamin' => $request->jenis_kelamin,
            'image' => $image_url
        ]);
        return redirect()->route('admin-list.index')->with(['pesan' => 'Admin berhasil diupdate!']);
    }

    public function destroy($id)
    {
        $petugas = Petugas::findOrFail($id);
        // Petugas::find($id)->delete();
        User::findOrFail($petugas->user_id)->delete();
        $petugas->delete();
        return back();
    }
}
