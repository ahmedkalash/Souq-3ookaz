@extends('customer.layouts.app')

@section('head')
    <title>Login</title>

@endsection


@push('style')
    <!-- slick css -->
    <link rel="stylesheet" type="text/css" href="{{asset('frontend')}}/assets/css/vendors/slick/slick.css">
    <link rel="stylesheet" type="text/css" href="{{asset('frontend')}}/assets/css/vendors/slick/slick-theme.css">

    <!-- Iconly css -->
    <link rel="stylesheet" type="text/css" href="{{asset('frontend')}}/assets/css/bulk-style.css">
@endpush


@section('content')

    <!-- log in section start -->
    <section class="log-in-section background-image-2 section-b-space">
        <div class="container-fluid-lg w-100">
            <div class="row">
                <div class="col-xxl-6 col-xl-5 col-lg-6 d-lg-block d-none ms-auto">
                    <div class="image-contain">
                        <img src="{{asset('frontend')}}/assets/images/inner-page/log-in.png" class="img-fluid" alt="">
                    </div>
                </div>

                <div class="col-xxl-4 col-xl-5 col-lg-6 col-sm-8 mx-auto">
                    <div class="log-in-box">
                        <div class="log-in-title">
                            <h3>Welcome To Fastkart</h3>
                            <h4>Log In Your Account</h4>
                        </div>

                        <div class="input-box">

                            @error('login_failed')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            @error('too_many_failed_login_attempts')
                                <div class="alert alert-danger">
                                    {{ $message }} !<br>
                                    You will be able to try again after {{session('lockup_minutes')}} Minuts.
                                </div>

                            @enderror

                            <form class="row g-4" method="post" action="{{route('customer.authenticate')}}">
                                @csrf
                                <div class="col-12">
                                    <div class="form-floating theme-form-floating log-in-form">
                                        <input type="email" class="form-control" id="email" placeholder="Email Address"  value="{{ old('email') }}" name="email">
                                        <label for="email">Email Address</label>
                                    </div>
                                </div>
                                @error('email')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                                <div class="col-12">
                                    <div class="form-floating theme-form-floating log-in-form">
                                        <input type="password" class="form-control" id="password"
                                               placeholder="Password" name="password">
                                        <label for="password">Password</label>
                                    </div>
                                </div>
                                 @error('password')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                 @enderror

                                <div class="col-12">
                                    <div class="forgot-box">
                                        <div class="form-check ps-0 m-0 remember-box">
                                            <input class="checkbox_animated check-box" type="checkbox"
                                                   id="flexCheckDefault" name="remember_me" {{ old('remember_me') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="flexCheckDefault">Remember me</label>
                                        </div>
                                        @error('remember_me')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                        <a href="forgot.html" class="forgot-password">Forgot Password?</a>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button class="btn btn-animation w-100 justify-content-center" type="submit">Log
                                        In</button>
                                </div>
                            </form>
                        </div>

                        <div class="other-log-in">
                            <h6>or</h6>
                        </div>

                        <div class="log-in-button">
                            <ul>
                                <li>
                                    <a href="{{route('customer.redirectToProvider','google')}}" class="btn google-button w-100">
                                        <img src="{{asset('frontend/assets/images/inner-page/google.png')}}" class="blur-up lazyload"
                                             alt=""> Log In with Google
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.facebook.com/" class="btn google-button w-100">
                                        <img src="{{asset('frontend/assets/images/inner-page/facebook.png')}}" class="blur-up lazyload"
                                             alt=""> Log In with Facebook
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="other-log-in">
                            <h6></h6>
                        </div>

                        <div class="sign-up-box">
                            <h4>Don't have an account?</h4>
                            <a href="{{route('customer.showRegistrationPage')}}">Sign Up</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- log in section end -->

@endsection


@push('scripts')

@endpush

