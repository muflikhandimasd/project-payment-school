@extends('layouts.backend.app')
@section('title', 'Data Siswa')
@push('css')
    <!-- DataTables -->
    <link rel="stylesheet"
        href="{{ asset('templates/backend/AdminLTE-3.1.0') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet"
        href="{{ asset('templates/backend/AdminLTE-3.1.0') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <!-- Sweetalert 2 -->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('templates/backend/AdminLTE-3.1.0') }}/plugins/sweetalert2/sweetalert2.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('templates/backend/AdminLTE-3.1.0') }}/plugins/select2/css/select2.min.css">
    <link rel="stylesheet"
        href="{{ asset('templates/backend/AdminLTE-3.1.0') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
@endpush
@section('content_title', 'Data Siswa')
@section('content')
    <x-alert></x-alert>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    @can('create-siswa')
                        <a href="{{ route('siswa.create') }}" class="btn btn-info mb-2">Tambah Siswa</a>
                    @endcan
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="siswaTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Foto</th>
                                <th>Nama Siswa</th>
                                <th>Nisn</th>
                                <th>Kelas</th>
                                <th>Jenis Kelamin</th>
                                <th>No Telepon</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($siswa as $k => $v)
                                <tr>
                                    <td>{{ $k += 1 }}</td>
                                    <td><img src="{{ $v->image }}" width="50" class="img-thumbnail rounded" alt="foto">
                                    </td>
                                    <td>{{ $v->nama_siswa }}</td>
                                    <td>{{ $v->nisn }}</td>
                                    <td>{{ $v->kelas->nama_kelas }}</td>
                                    <td>{{ $v->jenis_kelamin }}</td>
                                    <td>{{ $v->no_telepon }}</td>
                                    <td>
                                        <form action="{{ route('siswa.destroy', $v->id) }}" method="post"
                                            onsubmit="return confirm('Hapus {{ $v->nama_siswa }}')">
                                            @csrf
                                            @method('DELETE')
                                            <a href="{{ route('siswa.edit', $v->id) }}" class="btn btn-warning"><i
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
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->


@endsection

@push('js')
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('templates/backend/AdminLTE-3.1.0') }}/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('templates/backend/AdminLTE-3.1.0') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js">
    </script>
    <script
        src="{{ asset('templates/backend/AdminLTE-3.1.0') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js">
    </script>
    <script
        src="{{ asset('templates/backend/AdminLTE-3.1.0') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js">
    </script>
    <!-- Sweetalert 2 -->
    <script type="text/javascript"
        src="{{ asset('templates/backend/AdminLTE-3.1.0') }}/plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- Select2 -->
    <script src="{{ asset('templates/backend/AdminLTE-3.1.0') }}/plugins/select2/js/select2.full.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#siswaTable').DataTable();
        });
    </script>
@endpush
