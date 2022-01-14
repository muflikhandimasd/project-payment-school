@extends('layouts.backend.app')

@section('title', 'Form Tambah User')

@push('css')
    <style>
        .text-grey {
            color: #6c757d;
        }

        .text-grey:hover {
            color: #6c757d;
            text-decoration: none !important;
        }

    </style>
@endpush


@section('content_title', 'Tambah User')
@section('content')
    <div class="row">
        <div class="col-lg-6 col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">
                        Form Tambah User
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" id="username" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="image">Pilih Foto</label>
                            <input type="file" name="image" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select name="role" id="role" class="form-control" onchange="checkRole(this)">
                                <option disabled="">- PILIH ROLE -</option>
                                <option value="admin">Admin</option>
                                <option value="petugas">Petugas</option>
                                <option value="siswa">Siswa</option>
                            </select>
                        </div>
                        <div class="form-group" id="pilihan-kelas" style="display: none">
                            <label for="kelas_id">Kelas:</label>
                            <select required="" name="kelas_id" id="kelas_id" class="form-control select2bs4">
                                <option disabled="" selected="">- PILIH KELAS -</option>
                                @foreach ($kelas as $row)
                                    <option value="{{ $row->id }}">{{ $row->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-info" style="width: 100%">SIMPAN</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-12">
            @if (session()->has('username'))
                <div class="alert alert-danger">
                    {{ session()->get('username') }}
                </div>
            @endif
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger">
                        {{ $error }}
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    <script>
        const role = document.getElementById('role');
        const checkRole = (e) => {
            if (e.value === 'siswa') {
                document.getElementById('pilihan-kelas').style.display = 'block';
            } else {
                document.getElementById('pilihan-kelas').style.display = 'none';
            }
        }
    </script>
@endsection
