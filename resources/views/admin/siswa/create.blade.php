@extends('layouts.backend.app')

@section('title', 'Form Tambah Siswa')

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


@section('content_title', 'Tambah Siswa')
@section('content')
    <div class="row">
        <div class="col-lg-6 col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">
                        Form Tambah Siswa
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('siswa.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="nama_siswa">Nama Siswa</label>
                            <input type="text" name="nama_siswa" id="nama_siswa" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" id="username" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="nisn">Nisn</label>
                            <input required="" type="text" name="nisn" id="nisn" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="nis">Nis:</label>
                            <input required="" type="text" name="nis" id="nis" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="image">Pilih Foto</label>
                            <input type="file" name="image" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="jenis_kelamin">Jenis Kelamin:</label>
                            <select required="" name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                                <option disabled="" selected="">- PILIH JENIS KELAMIN -</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat:</label>
                            <input required="" type="text" name="alamat" id="alamat" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="no_telepon">No Telepon:</label>
                            <input required="" type="text" name="no_telepon" id="no_telepon" class="form-control">
                        </div>
                        <div class="form-group">
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
@endsection
