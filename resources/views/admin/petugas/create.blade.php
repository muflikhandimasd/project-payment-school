@extends('layouts.backend.app')

@section('title', 'Form Tambah Petugas')

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


@section('content_title', 'Tambah Petugas')
@section('content')
    <div class="row">
        <div class="col-lg-6 col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">
                        Form Tambah Petugas
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('petugas.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nama_petugas">Nama Petugas</label>
                            <input type="text" name="nama_petugas" id="nama_petugas" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" id="username" class="form-control" required>
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
