@extends('customer.layouts.app')

@section('head')
    <title> {{__("forget-password.Forgot Password page title")}} </title>
@endsection


@push('style')
    <!-- Google font -->
    <link href="https://fonts.googleapis.com/css2?family=Russo+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@400;500;600;700;800;900&display=swap"
          rel="stylesheet">

    <!-- slick css -->
    <link rel="stylesheet" type="text/css" href="{{asset('frontend')}}/assets/css/vendors/slick/slick.css">
    <link rel="stylesheet" type="text/css" href="{{asset('frontend')}}/assets/css/vendors/slick/slick-theme.css">


    <!-- Iconly css -->
    <link rel="stylesheet" type="text/css" href="{{asset('frontend')}}/assets/css/bulk-style.css">

@endpush


@section('content')

    <!-- log in section start -->
    <section class="log-in-section section-b-space forgot-section">
        <div class="container-fluid-lg w-100">
            <div class="row">
                <div class="col-xxl-6 col-xl-5 col-lg-6 d-lg-block d-none ms-auto">
                    <div class="image-contain">
                        <img src="{{asset('frontend')}}/assets/images/inner-page/forgot.png" class="img-fluid" alt="forgot password">
                    </div>
                </div>

                <div class="col-xxl-4 col-xl-5 col-lg-6 col-sm-8 mx-auto">
                    <div class="d-flex align-items-center justify-content-center h-100">
                        <div class="log-in-box">
                            <div class="log-in-title">
                                <h3>{{__("forget-password.Forgot your password?")}}</h3>
                                <h4>{{__("forget-password.Enter Your Email Address")}}</h4>
                            </div>

                            <div class="input-box">
                                <form class="row g-4" action="{{route('customer.sendPasswordResetEmail')}}" method="post">
                                    @csrf
                                    <div class="col-12">
                                        <div class="form-floating theme-form-floating log-in-form">

                                            <input type="email" class="form-control" id="email" name="email"
                                                   placeholder="{{__("forget-password.Email Address input placeholder")}}">
                                            <label for="email">{{__("forget-password.Email Address input title")}}</label>
                                        </div>
                                        @error('email')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <button class="btn btn-animation w-100" type="submit">
                                            {{__("forget-password.Send Password Reset Email")}}
                                        </button>
                                    </div>
                                </form>
                            </div>
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


<body>





