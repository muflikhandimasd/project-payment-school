<?php

namespace App\Http\Controllers\Admin;

use App\Models\Spp;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Petugas;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\DataTables\SiswaDataTable;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\CloudinaryStorage;

class SiswaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read-siswa'])->only(['index', 'show']);
        $this->middleware(['permission:create-siswa'])->only(['create', 'store']);
        $this->middleware(['permission:update-siswa'])->only(['edit', 'update']);
        $this->middleware(['permission:delete-siswa'])->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, SiswaDataTable $datatable)
    {
        $siswa = Siswa::all();
        $spp = Spp::all();
        $kelas = Kelas::all();

        return view('admin.siswa.index', compact('siswa', 'spp', 'kelas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $kelas =  Kelas::all();
        return view('admin.siswa.create', compact('kelas'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_siswa' => 'required',
            'username' => 'required|unique:users',
            'nisn' => 'required|unique:siswa',
            'nis' => 'required|unique:siswa',
            'alamat' => 'required',
            'no_telepon' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $user = User::create([
            'username' => Str::lower($request->username),
            'password' => Hash::make('spp12345678'),
        ]);

        $user->assignRole('siswa');
        $image  = $request->file('image');
        $image_url = CloudinaryStorage::upload($image->getRealPath(), $image->getClientOriginalName());
        Siswa::create([
            'user_id' => $user->id,
            'kode_siswa' => 'SSWR' . Str::upper(Str::random(5)),
            'image' => $image_url,
            'nisn' => $request->nisn,
            'nis' => $request->nis,
            'nama_siswa' => $request->nama_siswa,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'no_telepon' => $request->no_telepon,
            'kelas_id' => $request->kelas_id,
        ]);
        return redirect()->route('siswa.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $kelas =  Kelas::all();
        $siswa = Siswa::with(['kelas', 'spp'])->findOrFail($id);
        return view('admin.siswa.edit', ['siswa' => $siswa, 'kelas' => $kelas]);
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
        $validator = Validator::make($request->all(), [
            'nama_siswa' => 'required',
            'alamat' => 'required',
            'no_telepon' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $siswa = Siswa::findOrFail($id);

        $employee = new Siswa();
        $file   = $request->file('image');
        $image_url = CloudinaryStorage::replace($employee->image, $file->getRealPath(), $file->getClientOriginalName());

        $siswa->update([
            'nama_siswa' => $request->nama_siswa,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'no_telepon' => $request->no_telepon,
            'kelas_id' => $request->kelas_id,
            'image' => $image_url
        ]);
        return redirect()->route('siswa.index')->with(['pesan' => 'Siswa berhasil diupdate!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);
        User::findOrFail($siswa->user_id)->delete();
        $siswa->delete();
        return back();
    }
}
