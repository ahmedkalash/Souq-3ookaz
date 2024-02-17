@extends('customer.layouts.app')

@section('head')
        <title>{{__('register.Register page title')}}</title>
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
                            <h3>{{__('register.Welcome To Fastkart')}}</h3>
                            <h4>{{__('register.Create New Account')}}</h4>
                        </div>


                        @error('registration_failed')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div class="input-box">
                            <form class="row g-4" method="post" action="{{route('customer.register')}}">
                                @csrf
                                <div class="col-12">
                                    <div class="form-floating theme-form-floating">
                                        <input type="text" class="form-control" id="first_name" placeholder="{{__('register.First name input placeholder')}}" value="{{old('first_name')}}" name="first_name" required>
                                        <label for="first_name">{{__('register.First Name input title')}}</label>
                                    </div>
                                    @error('first_name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                 <div class="col-12">
                                    <div class="form-floating theme-form-floating">
                                        <input type="text" class="form-control" id="last_name" placeholder="{{__('register.Last name input placeholder')}}" value="{{old('last_name')}}" name="last_name" required>
                                        <label for="last_name">{{__('register.Last Name input title')}}</label>
                                    </div>
                                     @error('last_name')
                                     <div class="alert alert-danger">{{ $message }}</div>
                                     @enderror
                                 </div>


                                <div class="col-12">
                                    <div class="form-floating theme-form-floating">
                                        <input type="email" class="form-control" id="email" placeholder="{{__('register.Email Address input placeholder')}}" value="{{old('email')}}" name="email" required>
                                        <label for="email">{{__('register.Email Address input title')}}</label>
                                    </div>
                                    @error('email')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <div class="form-floating theme-form-floating">
                                        <input type="password" class="form-control" id="password"
                                               placeholder="{{__('register.Password input placeholder')}}"    name="password" required>
                                        <label for="password">{{__('register.Password input title')}}</label>
                                    </div>
                                    @error('password')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <div class="form-floating theme-form-floating">
                                        <input type="password" class="form-control" id="password_Conformation"
                                               placeholder="{{__('register.Password Conformation input placeholder')}}"   name="password_confirmation" required>
                                        <label for="password">{{__('register.Password Conformation input title')}}</label>
                                    </div>
                                    @error('password_confirmation')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <div class="forgot-box">
                                        <div class="form-check ps-0 m-0 remember-box">
                                            <input class="checkbox_animated check-box" type="checkbox"
                                                   id="flexCheckDefault" name="agree" REQUIRED>
                                            <label class="form-check-label" for="flexCheckDefault">
                                                {{__('register.I agree with Terms and Privacy')}}
                                                  </label>
                                        </div>
                                        @error('agree')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-12">
                                    <button class="btn btn-animation w-100" type="submit">{{__('register.Sign Up')}}</button>
                                </div>
                            </form>
                        </div>

                        <div class="other-log-in">
                            <h6>{{__('register.or')}}</h6>
                        </div>

                        <div class="log-in-button">
                            <ul>
                                <li>
                                    <a href="https://accounts.google.com/signin/v2/identifier?flowName=GlifWebSignIn&flowEntry=ServiceLogin"
                                       class="btn google-button w-100">
                                        <img src="{{asset('frontend')}}/assets/images/inner-page/google.png" class="blur-up lazyload"
                                             alt="">
                                        {{__('register.Sign up with Google')}}
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.facebook.com/" class="btn google-button w-100">
                                        <img src="{{asset('frontend')}}/assets/images/inner-page/facebook.png" class="blur-up lazyload"
                                             alt=""> {{__('register.Sign up with Facebook')}}
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="other-log-in">
                            <h6></h6>
                        </div>

                        <div class="sign-up-box">
                            <h4>{{__('register.Already have an account?')}}</h4>
                            <a href="{{route('customer.showLoginPage')}}"> {{__('register.Log In')}}  </a>
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





