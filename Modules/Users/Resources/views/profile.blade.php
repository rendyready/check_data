@extends('layouts.app')
@section('content')
    <!-- Page Content -->
    <div class="content">
        <div class="row items-push">
            <div class="col-md-6">
                <!-- Profil Pengguna -->
                <div class="block block-themed h-100 mb-0">
                    <div class="block-header bg-pulse">
                        <h3 class="block-title">User Profile</h3>
                    </div>
                    <div class="block-content text-muted">
                        <div class="block block-rounded text-center bg-gd-sun">
                            <div class="block-content block-content-full">
                                <img class="img-avatar" src="{{ asset('media/avatars/avatar15.jpg') }}" alt="">
                            </div>
                            <div class="block-content block-content-full block-content-sm bg-body-light">
                                <div class="fw-semibold mb-1">{{ ucwords(Auth::user()->name) }}</div>
                                <div class="fs-sm fw-medium text-muted">{{ Auth::user()->email }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <!-- Formulir Ganti Kata Sandi -->
                <div class="block block-themed h-100 mb-0">
                    <div class="block-header bg-pulse">
                        <h3 class="block-title">Change Password</h3>
                    </div>
                    <div class="block-content text-muted">
                        @if (session('error'))
                            <div id="error-alert" class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session('success'))
                            <div id="success-alert" class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <form method="POST" action="{{ route('users.pass_update') }}">
                            @csrf
                            <input type="hidden" name="email" value="{{ Auth::user()->email }}">
                            <div class="form-group">
                                <label for="new_password">Kata Sandi Baru</label>
                                <input type="password" name="new_password" id="new_password" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="new_password_confirmation">Konfirmasi Kata Sandi Baru</label>
                                <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                                    class="form-control" required>
                                <div id="password-error" class="text-danger"></div>
                            </div>
                            <button type="submit" class="btn btn-primary">Save Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- END Page Content -->
@endsection
@section('js')
    <script>
        @if (session('error'))
            setTimeout(function() {
                document.getElementById('error-alert').style.display = 'none';
            }, 3000); // Menghilangkan notifikasi setelah 3 detik
        @endif

        // Untuk notifikasi success
        @if (session('success'))
            setTimeout(function() {
                document.getElementById('success-alert').style.display = 'none';
            }, 3000); // Menghilangkan notifikasi setelah 3 detik
        @endif
        $(document).ready(function() {
            $('#new_password_confirmation').on('blur', function() {
                if ($('#new_password').val() === $('#new_password_confirmation').val()) {
                    $('#password-error').html('');
                } else {
                    $('#password-error').html('Kata Sandi Baru dan Konfirmasi Kata Sandi tidak cocok.');
                }
            });
        });
    </script>
@endsection
