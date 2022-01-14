@extends('layouts.backend.app')

@section('title', 'Form Edit User')

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


@section('content_title', 'Edit User')
@section('content')
    <div class="row">
        <div class="col-lg-6 col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">
                        Form Edit User
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" value="{{ $user->email }}" name="email" id="email" class="form-control"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="hidden" name="old_password" id="old_password" class="form-control">
                            <input type="password" id="password" name="password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="image">Pilih Foto</label>
                            <input type="file" name="image" class="form-control" required>
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
        $(document).on('click', '.user', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Peringatan!',
                text: "Yakin akan menghapus user?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#28B7B5',
                confirmButtonText: 'OK',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "DELETE",
                        url: '{{ route('user.destroy', $user->id) }}',
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response == 'success') {
                                Swal.fire({
                                    title: 'Pemberitahuan!',
                                    text: "User berhasil dihapus!",
                                    icon: 'success',
                                    confirmButtonColor: '#28B7B5',
                                    confirmButtonText: 'OK',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        location.href =
                                            "{{ route('user.index') }}";
                                    } else {
                                        location.href =
                                            "{{ route('user.index') }}";
                                    }
                                });
                            }
                        },
                        error: function(data) {
                            Swal.fire({
                                title: 'Pemberitahuan!',
                                text: "User gagal dihapus!",
                                icon: 'error',
                                confirmButtonColor: '#28B7B5',
                                confirmButtonText: 'OK',
                            });
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'Pemberitahuan!',
                        text: "User gagal dihapus!",
                        icon: 'error',
                        confirmButtonColor: '#28B7B5',
                        confirmButtonText: 'OK',
                    });
                }
            });
        });
    </script>
@endpush
