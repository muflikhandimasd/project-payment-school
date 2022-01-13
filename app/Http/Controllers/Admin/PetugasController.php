<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Petugas;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\DataTables\PetugasDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\CloudinaryStorage;

class PetugasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, PetugasDataTable $datatable)
    {
        $petugas = Petugas::all();

        return view('admin.petugas.index', compact('petugas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        return view('admin.petugas.create');
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'nama_petugas' => ['required', 'string', 'max:255'],
            'username' => ['required'],
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate);
        }

        $user = User::create([
            'username' => Str::lower($request->username),
            'password' => Hash::make('spp12345678'),
        ]);
        $user->assignRole('petugas');
        $image  = $request->file('image');
        $image_url = CloudinaryStorage::upload($image->getRealPath(), $image->getClientOriginalName());

        Petugas::create([
            'nama_petugas' => $request->nama_petugas,
            'user_id' => $user->id,
            'kode_petugas' => 'PTGR' . Str::upper(Str::random(5)),
            'image' => $image_url,
            'nama_petugas' => $request->nama_petugas,
            'jenis_kelamin' => $request->jenis_kelamin,
        ]);

        return redirect()->route('petugas.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $petugas = Petugas::find($id);

        return view('admin.petugas.edit', ['petugas' => $petugas]);
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
        $validate = Validator::make($request->all(), [
            'nama_petugas' => ['required', 'string', 'max:255'],
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate);
        }

        $petugas = Petugas::find($id);

        $employee = new Petugas();
        $file   = $request->file('image');
        $image_url = CloudinaryStorage::replace($employee->image, $file->getRealPath(), $file->getClientOriginalName());

        $petugas->update([
            'nama_petugas' => $request->nama_petugas,
            'jenis_kelamin' => $request->jenis_kelamin,
            'image' => $image_url
        ]);
        return redirect()->back()->with(['pesan' => 'Petugas berhasil diupdate!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $petugas = Petugas::finfOrFail($id);
        $petugas->delete();
        return 'success';
    }
}
