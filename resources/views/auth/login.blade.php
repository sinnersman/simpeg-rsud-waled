<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="description" content="{{ config('app.name') }} - {{ env('APP_DESC') }}">
  <meta name="author" content="{{  env('APP_AUTHOR') }}">
  <meta name="keywords" content="{{ env('APP_KEYWORDS') }}">
  <meta name="icon" content="{{ asset('/') }}assets/images/favicon.png">
  <title>{{ config('app.name') }} - {{ env("APP_DESC") }}</title>
  <script src="{{ asset('/') }}assets/js/color-modes.js"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com/">
  <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&amp;display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('/') }}assets/vendors/core/core.css">
  <link rel="stylesheet" href="{{ asset('/') }}assets/css/demo1/style.css">
  <link rel="shortcut icon" href="{{ asset('/') }}assets/images/favicon.png" />
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
  <div class="main-wrapper">
    <div class="page-wrapper full-page">
      <div class="page-content container-xxl d-flex align-items-center justify-content-center">
        <div class="row w-100 mx-0 auth-page">
          <div class="col-md-10 col-lg-8 col-xl-6 mx-auto">
            <div class="card">
              <div class="row">
                <div class="col-md-4 pe-md-0">
                  <div class="auth-side-wrapper">
                    
                  </div>
                </div>
                <div class="col-md-8 ps-md-0">
                  <div class="auth-form-wrapper px-4 py-5">
                    <a href="#" class="nobleui-logo d-block mb-2">{{ config('app.name') }} <span>V.{{ env('APP_VERSION') }}</span></a>
                    <h5 class="text-secondary fw-normal mb-4">Welcome back! Log in to your account.</h5>
                    <form class="forms-sample" method="POST" action="{{ route('login') }}">
                      @csrf
                      @if (session('status'))
                          <div class="alert alert-success" role="alert">
                              {{ session('status') }}
                          </div>
                      @endif
                      @if ($errors->any())
                          <div class="alert alert-danger">
                              <ul class="mb-0">
                                  @foreach ($errors->all() as $error)
                                      <li>{{ $error }}</li>
                                  @endforeach
                              </ul>
                          </div>
                      @endif
                      <div class="mb-3">
                        <label for="userEmail" class="form-label">Username</label>
                        <input type="username" class="form-control" id="username" name="username" value="{{ old('username') }}" placeholder="Username">
                      </div>
                      <div class="mb-3">
                        <label for="userPassword" class="form-label">Password</label>
                        <div class="input-group">
                          <input type="password" class="form-control" id="userPassword" name="password" autocomplete="current-password" placeholder="Password" value="{{ old('password') }}">
                          <span class="input-group-text" id="togglePassword" style="cursor: pointer;">
                            <i class="fa fa-eye"></i>
                          </span>
                        </div>
                      </div>
                      <div>
                        <button type="submit" class="btn btn-primary me-2 mb-2 mb-md-0 text-white">Login</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
      </div>
      <footer>
        <div class="footer-bottom border-top-0">
          <div class="d-flex flex-column flex-sm-row align-items-center justify-content-center">
            <span class="text-muted d-block text-center text-sm-start d-sm-inline-block">Copyright © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</span>
            {{-- <span class="text-muted d-block text-center text-sm-start d-sm-inline-block">Hand-crafted & made with <i class="bi bi-heart-fill text-danger"></i></span> --}}
          </div>
        </div>
      </footer>
    </div>
  </div>
  {{-- <script src="{{ asset('/') }}assets/vendors/core/core.js"></script> --}}
  {{-- <script src="{{ asset('/') }}assets/js/app.js"></script> --}}
  <script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#userPassword');

    togglePassword.addEventListener('click', function (e) {
      // toggle the type attribute
      const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
      password.setAttribute('type', type);
      // toggle the eye icon
      this.querySelector('i').classList.toggle('fa-eye-slash');
    });
  </script>
</body>
</html>