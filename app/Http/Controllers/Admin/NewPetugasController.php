<?php

namespace App\Http\Controllers\Admin;

use App\Models\Petugas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CloudinaryStorage;


class NewPetugasController extends Controller
{

    // set index page view
    public function index()
    {
        return view('admin.petugas.index');
    }

    // handle fetch all eamployees ajax request
    public function fetchAll()
    {
        $emps = Petugas::all();
        $output = '';
        $no = 1;
        if ($emps->count() > 0) {
            $output .= '<table class="table table-striped table-sm text-center align-middle">
            <thead>
              <tr>
                
                <th>No</th>
                <th>Username</th>
                <th>Foto</th>  
                <th>Nama Petugas</th>
                <th>Jenis Kelamin</th>
                <th>Kode Petugas</th>
                
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>';
            foreach ($emps as $emp) {
                $output .= '<tr>
                
                <td>' . $no++ . '</td>
                <td>' . $emp->username . '</td>
                <td><img src="' . $emp->image . '" width="50" class="img-thumbnail rounded"></td>
                <td>' . $emp->nama_petugas .  '</td>
                <td>' . $emp->jenis_kelamin . '</td>
                <td>' . $emp->kode_petugas . '</td>
                
                <td>
                  <a href="#" id="' . $emp->id . '" class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editPetugasModal"><i class="bi-pencil-square h4"></i></a>

                  <a href="#" id="' . $emp->id . '" class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i></a>
                </td>
              </tr>';
            }
            $output .= '</tbody></table>';
            echo $output;
        } else {
            echo '<h1 class="text-center text-secondary my-5">Belum ada Data Petugas!</h1>';
        }
    }

    // handle insert a new employee ajax request
    public function store(Request $request)
    {
        // $file = $request->file('avatar');
        // $fileName = time() . '.' . $file->getClientOriginalExtension();
        // $file->storeAs('public/images', $fileName);
        $image  = $request->file('image');
        $image_url = CloudinaryStorage::upload($image->getRealPath(), $image->getClientOriginalName());

        $empData = ['nama_petugas' => $request->nama_petugas, 'username' => $request->username, 'jenis_kelamin' => $request->jenis_kelamin, 'kode_petugas' => $request->kode_petugas,  'image' => $image_url];
        Petugas::create($empData);
        return response()->json([
            'status' => 200,
        ]);
    }

    // handle edit an employee ajax request
    public function edit(Request $request)
    {
        $id = $request->id;
        $emp = Petugas::find($id);
        return response()->json($emp);
    }

    // handle update an employee ajax request
    public function update(Request $request)
    {
        // $fileName = '';

        $emp = Petugas::find($request->emp_id);
        if ($request->hasFile('image')) {

            // $file = $request->file('avatar');
            // $fileName = time() . '.' . $file->getClientOriginalExtension();
            // $file->storeAs('public/images', $fileName);
            $employee = new Petugas();
            $file   = $request->file('image');
            $result = CloudinaryStorage::replace($employee->image, $file->getRealPath(), $file->getClientOriginalName());
            if ($emp->image) {
                // Storage::delete('public/images/' . $emp->avatar);
                CloudinaryStorage::delete($employee->image);
            }
        } else {
            // $fileName = $request->emp_avatar;
            $employee = new Petugas();
            $file   = $request->file('image');
            $image_url = CloudinaryStorage::replace($employee->image, $file->getRealPath(), $file->getClientOriginalName());
        }

        $empData = ['nama_petugas' => $request->nama_petugas, 'username' => $request->username, 'jenis_kelamin' => $request->jenis_kelamin, 'kode_petugas' => $request->kode_petugas,  'image' => $image_url];

        $emp->update($empData);
        return response()->json([
            'status' => 200,
        ]);
    }

    // handle delete an employee ajax request
    public function delete(Request $request)
    {
        $id = $request->id;
        $employee = new Petugas();
        // $emp = Employee::find($id);
        if (
            // Storage::delete('public/images/' . $emp->avatar)
            CloudinaryStorage::delete($employee->image)
        ) {
            Petugas::destroy($id);
        }
    }
}
