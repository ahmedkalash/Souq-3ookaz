@extends('customer.layouts.app')

@section('head')
        <title> {{__("password-reset.Password reset")}}  </title>
@endsection


@section('content')

    <!-- log in section start -->
    <section class="log-in-section section-b-space">
        <div class="container-fluid-lg w-100">
            <div class="row">
                <div class="col-xxl-6 col-xl-5 col-lg-6 d-lg-block d-none ms-auto">
                    <div class="image-contain">
                        <img src="{{asset('frontend')}}/assets/images/inner-page/sign-up.png" class="img-fluid" alt="">
                    </div>
                </div>

                <div class="col-xxl-4 col-xl-5 col-lg-6 col-sm-8 mx-auto">
                    <div class="log-in-box">
                        <div class="log-in-title">
                            <h3>{{__("password-reset.Reset your password")}}  </h3>
{{--                            <h4>Create New Account</h4>--}}
                        </div>

                        @error('registration_failed')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div class="input-box">
                            <form class="row g-4" method="post" action="{{route('customer.passwordReset')}}">
                                @csrf

                                <div class="col-12">
                                    <div class="form-floating theme-form-floating">
                                        <input type="password" class="form-control" id="password"
                                               placeholder="{{__("password-reset.Password input placeholder")}} "    name="password" required>
                                        <label for="password">{{__("password-reset.New Password input title")}} </label>
                                    </div>
                                    @error('password')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <div class="form-floating theme-form-floating">
                                        <input type="password" class="form-control" id="password_Conformation"
                                               placeholder="{{__("password-reset.Password Conformation input placeholder")}} "   name="password_confirmation" required>
                                        <label for="password_Conformation">{{__("password-reset.Password Conformation input title")}} </label>
                                    </div>
                                    @error('password_confirmation')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="col-12">
                                    <button class="btn btn-animation w-100" type="submit">{{__("password-reset.Change Password")}} </button>
                                </div>
                            </form>
                        </div>

                        <div class="other-log-in">
                            <h6></h6>
                        </div>

                        <div class="sign-up-box">
                            <a href="{{route('customer.showLoginPage')}}"> {{__("password-reset.Log In")}} </a>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-7 col-xl-6 col-lg-6"></div>
            </div>
        </div>
    </section>
    <!-- log in section end -->

@endsection


@push('scripts')

@endpush





