<!DOCTYPE html>
<html lang="en">
@include('layouts.header')
<body>
<div class="bg-body-dark">
    <div class="row mx-0 justify-content-center">
      <div class="hero-static col-lg-6 col-xl-4">
        <div class="content content-full overflow-hidden">
          <!-- Header -->
          <div class="py-4 text-center">
            <a class="link-fx fw-bold" href="index.php">
              <i class="fa fa-fire"></i>
              <span class="fs-4 text-body-color">Sipedas</span><span class="fs-4">V4</span>
            </a>
            <h1 class="h3 fw-bold mt-4 mb-2">Selamat Datang Para Pedas</h1>
            <h2 class="h5 fw-medium text-muted mb-0"> ”Sebaik-baik pekerjaan ialah usahanya seseorang pekerja apabila ia berbuat sebaik-baiknya (propesional).” (HR. Ahmad)</h2>
          </div>
          <!-- END Header -->
  
          <!-- Sign In Form -->
          <!-- jQuery Validation functionality is initialized with .js-validation-signin class in js/pages/op_auth_signin.min.js which was auto compiled from _js/pages/op_auth_signin.js -->
          <!-- For more examples you can check out https://github.com/jzaefferer/jquery-validation -->
          <form class="js-validation-signin" action="{{route('login')}}" method="POST">
            @csrf
            <div class="block block-themed block-rounded block-fx-shadow">
              <div class="block-header bg-gd-dusk">
                <h3 class="block-title">Please Sign In</h3>
              </div>
              <div class="block-content">
                <div class="form-floating mb-4">
                  <input id="login-username" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Enter your username">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                  <label class="form-label" for="login-username">Username</label>
                </div>
                <div class="form-floating mb-4">
                <input id="login-password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                  <label class="form-label" for="login-password">Password</label>
                </div>
                <div class="row">
                  <div class="col-sm-6 d-sm-flex align-items-center push">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="login-remember-me" name="login-remember-me">
                      <label class="form-check-label" for="login-remember-me">Remember Me</label>
                    </div>
                  </div>
                  <div class="col-sm-6 text-sm-end push">
                    <button type="submit" class="btn btn-lg btn-alt-primary fw-medium">
                      Sign In
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </form>
          <!-- END Sign In Form -->
        </div>
      </div>
    </div>
  </div>
  </div>
</div>
<!-- END Page Content -->
</body>
</html>