<!DOCTYPE html>

<html lang="en">

  <head>

    <!-- Required meta tags -->

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Register </title>

    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">

    <!-- endinject -->

    <link rel="shortcut icon" href="{{assert('assets/images/favicon.png')}}" />

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

                <h4>New here?</h4>

                <h6 class="fw-light">Signing up is easy. It only takes a few steps</h6>

                <form class="pt-3" method="POST" action="{{ route('register') }}">

                    @csrf

                  <div class="form-group">

                    <input type="text" name="name" value="{{old('name')}}" class="form-control form-control-lg @error('name') is-invalid @enderror" id="name" placeholder="Firm Name">

                    @error('name')<div style="color: red; font-size:14px">{{$message}}</div>@enderror

                </div>

                  <div class="form-group">

                    <input type="email" value="{{old('email')}}" name="email" class="form-control form-control-lg @error('email') is-invalid @enderror" id="email" placeholder="Email">

                    @error('email')<div style="color: red; font-size:14px">{{$message}}</div>@enderror

                </div>

                <div class="form-group">

                    <input type="password" name="password" class="form-control form-control-lg @error('password') is-invalid @enderror" id="password" placeholder="Password">

                    @error('password')<div style="color: red; font-size:14px">{{$message}}</div>@enderror

                </div>

                <div class="form-group">

                    <input type="password" name="password_confirmation" class="form-control form-control-lg @error('password_confirmation') is-invalid @enderror" id="password_confirmation" placeholder="Password Confirmation">

                    @error('password_confirmation')<div style="color: red; font-size:14px">{{$message}}</div>@enderror

                </div>

                  <div class="mt-3 d-grid gap-2">

                    <button type="submit" class="btn btn-block btn-primary btn-lg fw-medium auth-form-btn">SIGN UP</button>

                  </div>

                  <div class="text-center mt-4 fw-light"> Already have an account? <a href="{{route('login')}}" class="text-primary">Login</a>

                  </div>

                </form>

              </div>

            </div>

          </div>

        </div>

      </div>

    </div>

  </body>

</html>