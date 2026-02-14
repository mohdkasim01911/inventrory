<!DOCTYPE html>

<html lang="en">

  <head>

    <!-- Required meta tags -->

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Login</title>

    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">

    <!-- endinject -->

    <link rel="shortcut icon" href="{{asset('assets/images/favicon.png')}}" />

  </head>

  <body>

    <div class="container-scroller">

      <div class="container-fluid page-body-wrapper full-page-wrapper">

        <div class="content-wrapper d-flex align-items-center auth px-0">

          <div class="row w-100 mx-0">

            <div class="col-lg-4 mx-auto">

              <div class="auth-form-light text-left py-5 px-4 px-sm-5">

                <div class="brand-logo">

                  <img src="{{asset('assets/images/logo.svg')}}" alt="logo">

                </div>

                <h4>Hello! let's get started</h4>

                <h6 class="fw-light">Sign in to continue.</h6>

                <form class="pt-3" method="POST" action="{{ route('login') }}">

                    @csrf

                  <div class="form-group">

                    <input type="email" name="email" value="{{old('email')}}" class="form-control form-control-lg @error('email') is-invalid @enderror" id="email" placeholder="Email">

                    @error('email')<div style="color: red; font-size:14px">{{$message}}</div>@enderror

                </div>

                  <div class="form-group">

                    <input type="password" name="password" class="form-control form-control-lg @error('password') is-invalid @enderror" id="password" placeholder="Password">

                    @error('password')<div style="color: red; font-size:14px">{{$message}}</div>@enderror

                </div>

                  <div class="mt-3 d-grid gap-2">

                    <button type="submit" class="btn btn-block btn-primary btn-lg fw-medium auth-form-btn">SIGN IN</button>

                  </div>

                  <div class="my-2 d-flex justify-content-between align-items-center">

                    <a href="{{ route('password.request') }}" class="auth-link text-black">Forgot password?</a>

                  </div>

                  <div class="text-center mt-4 fw-light"> Don't have an account? <a href="{{route('register')}}" class="text-primary">Create</a>

                  </div>

                </form>

              </div>

            </div>

          </div>

        </div>

        <!-- content-wrapper ends -->

      </div>

      <!-- page-body-wrapper ends -->

    </div>

    <!-- container-scroller -->

  </body>

</html>