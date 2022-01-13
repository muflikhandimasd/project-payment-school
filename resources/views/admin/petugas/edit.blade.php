@extends('layouts.backend.app')

@section('title', 'Form Edit Petugas')

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


@section('content_title', 'Edit Petugas')
@section('content')
    <div class="row">
        <div class="col-lg-6 col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">
                        Form Edit Petugas
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('petugas.update', $petugas->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label for="nama_petugas">Nama Petugas</label>
                            <input type="text" value="{{ $petugas->nama_petugas }}" name="nama_petugas" id="nama_petugas"
                                class="form-control" required>
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
                        <button type="submit" class="btn btn-warning text-white" style="width: 100%">UPDATE</button>
                    </form>

                </div>
            </div>
        </div>
        <div class="col-lg-6 col-12">
            @if (session()->has('notif'))
                <div class="alert alert-danger">
                    {{ session()->get('notif') }}
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

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    @if (session()->has('pesan'))
        <script>
            Swal.fire({
                title: 'Pemberitahuan!',
                text: '{{ session()->get('pesan') }}',
                icon: 'success',
                confirmButtonColor: '#28B7B5',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    location.reload();
                } else {
                    location.reload();
                }
            });
        </script>
    @endif
    <script>
        $(document).on('click', '.petugas', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Peringatan!',
                text: "Yakin akan menghapus petugas?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#28B7B5',
                confirmButtonText: 'OK',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "DELETE",
                        url: '{{ route('petugas.destroy', $petugas->id) }}',
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response == 'success') {
                                Swal.fire({
                                    title: 'Pemberitahuan!',
                                    text: "Petugas berhasil dihapus!",
                                    icon: 'success',
                                    confirmButtonColor: '#28B7B5',
                                    confirmButtonText: 'OK',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        location.href =
                                            "{{ route('petugas.index') }}";
                                    } else {
                                        location.href =
                                            "{{ route('petugas.index') }}";
                                    }
                                });
                            }
                        },
                        error: function(data) {
                            Swal.fire({
                                title: 'Pemberitahuan!',
                                text: "Petugas gagal dihapus!",
                                icon: 'error',
                                confirmButtonColor: '#28B7B5',
                                confirmButtonText: 'OK',
                            });
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'Pemberitahuan!',
                        text: "Petugas gagal dihapus!",
                        icon: 'error',
                        confirmButtonColor: '#28B7B5',
                        confirmButtonText: 'OK',
                    });
                }
            });
        });
    </script>
@endpush
