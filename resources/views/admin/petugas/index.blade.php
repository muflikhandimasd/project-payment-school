@extends('layouts.backend.app')
@section('title', 'Data Petugas')
@push('css')
    <!-- DataTables -->
    <link rel="stylesheet"
        href="{{ asset('templates/backend/AdminLTE-3.1.0') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet"
        href="{{ asset('templates/backend/AdminLTE-3.1.0') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <!-- Sweetalert 2 -->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('templates/backend/AdminLTE-3.1.0') }}/plugins/sweetalert2/sweetalert2.min.css">
@endpush
@section('content_title', 'Data Petugas')
@section('content')
    <x-alert></x-alert>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-info">
                Data Petugas
            </h6>
        </div>
        <div class="card-body">
            <a href="{{ route('petugas.create') }}" class="btn btn-info mb-2">Tambah Petugas</a>
            <table id="petugasTable" class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Petugas</th>
                        <th>Kode Petugas</th>
                        <th>Foto</th>
                        <th>Jenis Kelamin</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($petugas as $k => $v)
                        <tr>
                            <td>{{ $k += 1 }}</td>
                            <td>{{ $v->nama_petugas }}</td>
                            <td>{{ $v->kode_petugas }}</td>

                            <td><img src="{{ $v->image }}" width="50" class="img-thumbnail rounded" alt="foto"></td>
                            <td>{{ $v->jenis_kelamin }}</td>
                            <td>
                                <form action="{{ route('petugas.destroy', $v->id) }}" method="post"
                                    onsubmit="return confirm('Hapus {{ $v->nama_petugas }}')">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ route('petugas.edit', $v->id) }}" class="btn btn-warning"><i
                                            class="fa fa-edit"></i>Edit</a>
                                    <button type="submit" class="btn btn-danger"><i class="fa fa-trash">
                                            Hapus</i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

@push('js')
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#petugasTable').DataTable();
        });
    </script>
@endpush
