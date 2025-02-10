@extends('authentication.template')

@section('content')

  <main class="main-content  mt-0">
    <section>
      <div class="page-header min-vh-75">
        <div class="container">
          <div class="row">
            <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
              <div class="card card-plain mt-8">
                <div class="card-header pb-0 text-left bg-transparent">
                  <h3 class="font-weight-bolder text-info text-gradient">Create New Account</h3>
                  <p class="mb-0">Create a new account<br></p>
                  <p class="mb-0">OR Sign in with these credentials:</p>
                </div>
                <div class="card-body">
                  <form role="form" method="POST" action="{{asset('signup')}}">
                    @csrf
                    <label>Name</label>
                    <div class="mb-3">
                      <input type="text" class="form-control" value="{{old('name')}}" name="name" id="name" placeholder="Name" aria-label="Name" aria-describedby="name-addon">
                      @error('name')
                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                      @enderror
                    </div>
                    <label>Email</label>
                    <div class="mb-3">
                      <input type="email" class="form-control" value="{{old('email')}}" name="email" id="email" placeholder="Email" aria-label="Email" aria-describedby="email-addon">
                      @error('email')
                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                      @enderror
                    </div>
                    <label>Password</label>
                    <div class="mb-3">
                      <input type="password" class="form-control" name="password" id="password" placeholder="Password" aria-label="Password" aria-describedby="password-addon">
                      @error('password')
                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                      @enderror
                    </div>
                    <label>Confirm Password</label>
                    <div class="mb-3">
                      <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" aria-label="Confirm Password" aria-describedby="password_confirmation-addon">
                      @error('password_confirmation')
                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                      @enderror
                    </div>
                    <div class="text-center">
                      <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">Sign Up</button>
                    </div>
                  </form>
                </div>
                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                  <p class="mb-4 text-sm mx-auto">
                    Already have an account?
                    <a href="signin" class="text-info text-gradient font-weight-bold">Sign In</a>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

@endsection
