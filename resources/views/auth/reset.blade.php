<!DOCTYPE html>
<html lang="en">
@include('layouts.header')
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-pulse"></div>
                <h3 class="text-center">Anda Login Dengan Password Default Silahkan Ganti !!!</h3>
                <div class="card-body">
                    <form method="POST" action="{{ route('password.changes') }}">
                        @csrf
                        <input type="hidden" name="reset_token" value="{{ $token }}">
                        <input type="hidden" name="verified" value="{{$verified}}">
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">Username</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ $email }}" readonly>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">New Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>
                        <h3 class="text-center">Pastikan Untuk Menyimpan Informasi User Dan Password Anda</h3>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script>
    const password = document.getElementById("password");
    const confirmPassword = document.getElementById("password-confirm");
    
    function validatePassword() {
        if (password.value != confirmPassword.value) {
            confirmPassword.setCustomValidity("Passwords Tidak Sama");
        } else {
            confirmPassword.setCustomValidity("");
        }
    }
    
    password.addEventListener("change", validatePassword);
    confirmPassword.addEventListener("change", validatePassword);
</script>
</html>
