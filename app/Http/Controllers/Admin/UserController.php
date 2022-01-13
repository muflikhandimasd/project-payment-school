<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Siswa;
use App\Models\Petugas;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\DataTables\UserDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\CloudinaryStorage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, UserDataTable $datatable)
    {
        $user = User::all();
        $petugas = Petugas::all();
        $siswa = Siswa::all();

        return view('admin.user.index', compact('user', 'siswa', 'petugas'));
    }
    public function create()
    {
        $user = User::all();
        $petugas = Petugas::all();
        $siswa = Siswa::all();
        return view('admin.user.create', compact('user', 'siswa', 'petugas'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.edit', compact('user'));
    }

    public function store(Request $request)
    {
        if ($request->role == 'admin') {
            $validator = Validator::make($request->all(), [
                'username' => 'required|unique:users',
                'email' => 'required|email|unique:users',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }
            $image = $request->file('image');
            $image_url = CloudinaryStorage::upload($image->getRealPath(), $image->getClientOriginalName());

            $user = User::create([
                'username' => Str::lower($request->username),
                'password' => Hash::make('spp12345678'),
                'email' => $request->email,
                'image' => $image_url
            ]);

            $user->assignRole('admin');

            $image = $request->file('image');
            $image_url = CloudinaryStorage::upload($image->getRealPath(), $image->getClientOriginalName());

            Petugas::create([
                'user_id' => $user->id,
                'kode_petugas' => 'PTGR' . Str::upper(Str::random(5)),
                'image' => $image_url
            ]);
        } elseif ($request->role == 'petugas') {
            $validate = Validator::make($request->all(), [
                'username' => 'required|unique:users',
                'email' => 'required|email|unique:users'
            ]);

            if ($validate->fails()) {
                return redirect()->back()->withErrors($validate);
            }

            $image = $request->file('image');
            $image_url = CloudinaryStorage::upload($image->getRealPath(), $image->getClientOriginalName());

            $user = User::create([
                'username' => Str::lower($request->username),
                'password' => Hash::make('spp12345678'),
                'email' => $request->email,
                'image' => $image_url
            ]);

            $user->assignRole('petugas');
            $image = $request->file('image');
            $image_url = CloudinaryStorage::upload($image->getRealPath(), $image->getClientOriginalName());

            Petugas::create([
                'user_id' => $user->id,
                'kode_petugas' => 'PTGR' . Str::upper(Str::random(5)),
                'image' => $image_url,

            ]);
        } elseif ($request->role == 'siswa') {
            $validator = Validator::make($request->all(), [

                'username' => 'required|unique:users',
                'email' => 'required|email|unique:users'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }

            $image = $request->file('image');
            $image_url = CloudinaryStorage::upload($image->getRealPath(), $image->getClientOriginalName());

            $user = User::create([
                'username' => Str::lower($request->username),
                'password' => Hash::make('spp12345678'),
                'email' => $request->email,
                'image' => $image_url
            ]);

            $user->assignRole('siswa');
            $image = $request->file('image');
            $image_url = CloudinaryStorage::upload($image->getRealPath(), $image->getClientOriginalName());

            Siswa::create([
                'user_id' => $user->id,
                'kode_siswa' => 'SSWR' . Str::upper(Str::random(5)),
                'image' => $image_url,
            ]);
        }
        return redirect()->route('user.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $employee = new User();
        $file = $request->file('image');
        $image_url = CloudinaryStorage::replace($employee->image, $file->getRealPath(), $file->getClientOriginalName());
        User::findOrFail($id)->update([
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $request->old_password,
            'image' => $image_url
        ]);
        return redirect()->route('user.index');
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return back();
    }
}
