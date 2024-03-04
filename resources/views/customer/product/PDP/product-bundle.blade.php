@extends('customer.layouts.app')

@section('head')
    <title>{{__('product-bundle.page title')}} </title>
@endsection



@push('style')
    <!-- wow css -->
    <link rel="stylesheet" href="{{asset('frontend')}}/assets/css/animate.min.css" />


    <!-- slick css -->
    <link rel="stylesheet" type="text/css" href="{{asset('frontend')}}/assets/css/vendors/slick/slick.css">
    <link rel="stylesheet" type="text/css" href="{{asset('frontend')}}/assets/css/vendors/slick/slick-theme.css">

    <!-- Iconly css -->
    <link rel="stylesheet" type="text/css" href="{{asset('frontend')}}/assets/css/bulk-style.css">

@endpush


@section('content')

    <!-- Product Left Sidebar Start -->
    <section class="product-section">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-xxl-9 col-xl-8 col-lg-7 wow fadeInUp">
                    <div class="row g-4">
                        <div class="col-xl-6 wow fadeInUp">
                            <div class="product-left-box">
                                <div class="row g-sm-4 g-2">
                                    <div class="col-12">
                                        <div class="product-main no-arrow">
                                            @foreach($product->gallery as $image)
                                                <div>
                                                    <div class="slider-image">
                                                        <img src="{{ $image->getFullUrl() }}"
                                                             {{($loop->index == 0)? "'id='img-1'": '' }}
                                                             data-zoom-image="{{ $image->getFullUrl() }}"
                                                             class="img-fluid image_zoom_cls-{{$loop->index}} blur-up lazyload" alt="">
                                                    </div>
                                                </div>
                                            @endforeach


{{--
                                         --- this commented code was replaced with the prevous code, and left to refer to in case of any problem with the design ---

                                      <div>
                                                <div class="slider-image">
                                                    <img src="{{ ($product->getMedia('gallery')[0]->getFullUrl()) }}"
                                                         --}}{{--id="img-1"--}}{{--
                                                         data-zoom-image="{{ ($product->getMedia('gallery')[0]->getFullUrl()) }}"
                                                         class="img-fluid image_zoom_cls-0 blur-up lazyload" alt="">
                                                </div>
                                            </div>

                                            <div>
                                                <div class="slider-image">
                                                    <img src="{{asset('frontend')}}/assets/images/product/category/2.jpg"
                                                         data-zoom-image="../assets/images/product/category/2.jpg" class="
                                                        img-fluid image_zoom_cls-1 blur-up lazyload" alt="">
                                                </div>
                                            </div>

                                            <div>
                                                <div class="slider-image">
                                                    <img src="../assets/images/product/category/3.jpg"
                                                         data-zoom-image="../assets/images/product/category/3.jpg" class="
                                                        img-fluid image_zoom_cls-2 blur-up lazyload" alt="">
                                                </div>
                                            </div>

                                            <div>
                                                <div class="slider-image">
                                                    <img src="../assets/images/product/category/4.jpg"
                                                         data-zoom-image="../assets/images/product/category/4.jpg" class="
                                                        img-fluid image_zoom_cls-3 blur-up lazyload" alt="">
                                                </div>
                                            </div>

                                            <div>
                                                <div class="slider-image">
                                                    <img src="../assets/images/product/category/5.jpg"
                                                         data-zoom-image="../assets/images/product/category/5.jpg" class="
                                                        img-fluid image_zoom_cls-4 blur-up lazyload" alt="">
                                                </div>
                                            </div>

                                            <div>
                                                <div class="slider-image">
                                                    <img src="../assets/images/product/category/6.jpg"
                                                         data-zoom-image="../assets/images/product/category/6.jpg" class="
                                                        img-fluid image_zoom_cls-5 blur-up lazyload" alt="">
                                                </div>
                                            </div>--}}

                                        </div>
                                    </div>

                                    <div class="col-12">

                                        <div class="left-slider-image left-slider no-arrow slick-top">

                                            @foreach($product->gallery as $image)
                                                <div>
                                                    <div class="sidebar-image">
                                                        <img src="{{ $image->getFullUrl() }}"
                                                             class="img-fluid blur-up lazyload" alt="">
                                                    </div>
                                                </div>
                                            @endforeach

 {{--

                                            <div>
                                                <div class="sidebar-image">
                                                    <img src="{{asset('frontend')}}/assets/images/product/category/1.jpg"
                                                         class="img-fluid blur-up lazyload" alt="">
                                                </div>
                                            </div>

                                            <div>
                                                <div class="sidebar-image">
                                                    <img src="{{asset('frontend')}}/assets/images/product/category/2.jpg"
                                                         class="img-fluid blur-up lazyload" alt="">
                                                </div>
                                            </div>

                                            <div>
                                                <div class="sidebar-image">
                                                    <img src="../assets/images/product/category/3.jpg"
                                                         class="img-fluid blur-up lazyload" alt="">
                                                </div>
                                            </div>

                                            <div>
                                                <div class="sidebar-image">
                                                    <img src="../assets/images/product/category/4.jpg"
                                                         class="img-fluid blur-up lazyload" alt="">
                                                </div>
                                            </div>

                                            <div>
                                                <div class="sidebar-image">
                                                    <img src="../assets/images/product/category/5.jpg"
                                                         class="img-fluid blur-up lazyload" alt="">
                                                </div>
                                            </div>

                                            <div>
                                                <div class="sidebar-image">
                                                    <img src="../assets/images/product/category/6.jpg"
                                                         class="img-fluid blur-up lazyload" alt="">
                                                </div>
                                            </div>
--}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                        @php
                            if($product->has_special_price){
                                if($product->special_price_type=='percentage'){
                                    $product_special_price_percentage = $product->special_price;
                                    $product_special_price = round($product->price - (($product_special_price_percentage*$product->price)/100.0), 2);
                                }else{
                                    // then $product->special_price_type=='fixed'
                                    $product_special_price_percentage = round(100*($product->price - $product->special_price) / ($product->price==0 ? 100:$product->price), 2);
                                    $product_special_price = $product->special_price;
                                }
                            }
                        @endphp
                        <div class="col-xl-6 wow fadeInUp">
                            <div class="right-box-contain">
                                {!! $product->has_special_price ?  "<h6 class='offer-top'>$product_special_price_percentage% off</h6>" : '' !!}
                                <h2 class="name">{{ $product->name??null }}</h2>
                                <div class="price-rating">
                                    <h3 class="theme-color price">
                                        {!!  $product->has_special_price ? "$$product_special_price <del class='text-content'>$$product->price</del>" : "$$product->price"!!}
{{--                                        ${{$product->price??null}} <del class="text-content">$58.46</del>--}}
                                        <span class="offer theme-color">
                                             {!! $product->has_special_price ?  "($product_special_price_percentage% off)" : '' !!}
                                        </span></h3>
                                    <div class="product-rating custom-rate">
                                        {!! render_star_rating_for_front(round($product->reviews_avg_rate??0,2)) !!}

                                        <span class="review"> {{$product->reviews->count()}} Customer Review</span>
                                    </div>
                                </div>

                                <div class="procuct-contain">
                                     {!! $product->short_description??null !!}
                                </div>

                               {{--
                                product variants

                               <div class="product-packege">
                                    <div class="product-title">
                                        <h4>Weight</h4>
                                    </div>
                                    <ul class="select-packege">
                                        <li>
                                            <a href="javascript:void(0)" class="active">1/2 KG</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)">1 KG</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)">1.5 KG</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)">Red Roses</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)">With Pink Roses</a>
                                        </li>
                                    </ul>
                                </div>--}}

                                <div class="time deal-timer product-deal-timer mx-md-0 mx-auto" id="clockdiv-1"
                                     data-hours="1" data-minutes="2" data-seconds="3">
                                    <div class="product-title">
                                        <h4>Hurry up! Sales Ends In</h4>
                                    </div>
                                    <ul>
                                        <li>
                                            <div class="counter d-block">
                                                <div class="days d-block">
                                                    <h5></h5>
                                                </div>
                                                <h6>Days</h6>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="counter d-block">
                                                <div class="hours d-block">
                                                    <h5></h5>
                                                </div>
                                                <h6>Hours</h6>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="counter d-block">
                                                <div class="minutes d-block">
                                                    <h5></h5>
                                                </div>
                                                <h6>Min</h6>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="counter d-block">
                                                <div class="seconds d-block">
                                                    <h5></h5>
                                                </div>
                                                <h6>Sec</h6>
                                            </div>
                                        </li>
                                    </ul>
                                </div>

{{--                                @dump($errors )--}}
                                {!! render_validation_errors($errors) !!}

                                <div class="note-box product-packege">
                                    <div class="cart_qty qty-box product-qty">
                                        <form id="add-main-product-to-cart" action="{{route('customer.cart.add')}}" method="post">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{$product->id}}">
                                            <div class="input-group">
                                                <button type="button" class="qty-left-minus" data-type="minus"
                                                        data-field="">
                                                    <i class="fa fa-minus" aria-hidden="true"></i>
                                                </button>

                                                <input class="form-control input-number qty-input" type="text"
                                                       name="qty" value="0">

                                                <button type="button" class="qty-right-plus" data-type="plus" data-field="">
                                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                                </button>

                                            </div>
                                        </form>
                                    </div>

                                    <div class="input-group">
                                        <button form="add-main-product-to-cart" class="btn btn-md bg-dark cart-button text-white w-100" type="submit">Add To Cart</button>
                                    </div>


                                </div>

                                <div class="buy-box">
                                    <a href="wishlist.html">
                                        <i data-feather="heart"></i>
                                        <span>Add To Wishlist</span>
                                    </a>

                                    <a href="compare.html">
                                        <i data-feather="shuffle"></i>
                                        <span>Add To Compare</span>
                                    </a>
                                </div>

                                <div class="pickup-box">
                                    <div class="product-title">
                                        <h4>Store Information</h4>
                                    </div>

                                    <div class="pickup-detail">
                                        <h4 class="text-content">Lollipop cake chocolate chocolate cake dessert jujubes.
                                            Shortbread sugar plum dessert powder cookie sweet brownie.</h4>
                                    </div>

                                    <div class="product-info">
                                        <ul class="product-info-list product-info-list-2">
                                            <li>Type : <a>{{$product->type}}</a></li>
                                            <li>SKU : <a>{{$product->sku}}</a></li>
                                            <li>MFG : <a>{{$product->mfg}}</a></li>
                                            <li>Stock : <a>{{$product->stock}}</a></li>
{{--                                            <li>Tags : <a>Cake,</a> <a--}}
{{--                                                        >Backery</a></li>--}}
                                        </ul>
                                    </div>
                                </div>

                                <div class="paymnet-option">
                                    <div class="product-title">
                                        <h4>Guaranteed Safe Checkout</h4>
                                    </div>
                                    <ul>
                                        <li>
                                            <a href="javascript:void(0)">
                                                <img src="../assets/images/product/payment/1.svg"
                                                     class="blur-up lazyload" alt="">
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)">
                                                <img src="../assets/images/product/payment/2.svg"
                                                     class="blur-up lazyload" alt="">
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)">
                                                <img src="../assets/images/product/payment/3.svg"
                                                     class="blur-up lazyload" alt="">
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)">
                                                <img src="../assets/images/product/payment/4.svg"
                                                     class="blur-up lazyload" alt="">
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)">
                                                <img src="../assets/images/product/payment/5.svg"
                                                     class="blur-up lazyload" alt="">
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-3 col-xl-4 col-lg-5 d-none d-lg-block wow fadeInUp">
                    <div class="right-sidebar-box">
                        <div class="vendor-box">
                            <div class="verndor-contain">
                                <div class="vendor-image">
                                    <img src="../assets/images/product/vendor.png" class="blur-up lazyload" alt="">
                                </div>

                                <div class="vendor-name">
                                    <h5 class="fw-500">Noodles Co.</h5>

                                    <div class="product-rating mt-1">
                                        <ul class="rating">
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star" class="fill"></i>
                                            </li>
                                            <li>
                                                <i data-feather="star"></i>
                                            </li>
                                        </ul>
                                        <span>(36 Reviews)</span>
                                    </div>

                                </div>
                            </div>

                            <p class="vendor-detail">Noodles & Company is an American fast-casual
                                restaurant that offers international and American noodle dishes and pasta.</p>

                            <div class="vendor-list">
                                <ul>
                                    <li>
                                        <div class="address-contact">
                                            <i data-feather="map-pin"></i>
                                            <h5>Address: <span class="text-content">1288 Franklin Avenue</span></h5>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="address-contact">
                                            <i data-feather="headphones"></i>
                                            <h5>Contact Seller: <span class="text-content">(+1)-123-456-789</span></h5>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="pt-25">
                            <div class="hot-line-number">
                                <h5>Hotline Order:</h5>
                                <h6>Mon - Fri: 07:00 am - 08:30PM</h6>
                                <h3>(+1) 123 456 789</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Left Sidebar End -->

    <!-- Related Product Section Start -->
    <section class="related-product-2">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="related-product">
                        <div class="product-title-2">
                            <h4>Frequently bought together</h4>
                        </div>

                        <div class="related-box">
                            <div class="related-image">
                                <ul>
                                    <li>
                                        <div class="product-box product-box-bg wow fadeInUp">
                                            <div class="product-image">
                                                <a href="product-left-thumbnail.html">
                                                    <img src="../assets/images/cake/product/1.png"
                                                         class="img-fluid blur-up lazyload" alt="">
                                                </a>
                                            </div>
                                            <div class="product-detail">
                                                <a href="product-left-thumbnail.html">
                                                    <h6 class="name">
                                                        Muffets & Tuffets Whole Wheat Bread 400 g
                                                    </h6>
                                                </a>

                                                <h5 class="sold text-content">
                                                    <span class="theme-color price">$26.69</span>
                                                    <del>28.56</del>
                                                </h5>
                                            </div>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="product-box product-box-bg wow fadeInUp" data-wow-delay="0.1s">
                                            <div class="product-image">
                                                <a href="product-left-thumbnail.html">
                                                    <img src="../assets/images/cake/product/2.png"
                                                         class="img-fluid blur-up lazyload" alt="">
                                                </a>
                                            </div>
                                            <div class="product-detail">
                                                <a href="product-left-thumbnail.html">
                                                    <h6 class="name">
                                                        Fresh Bread and Pastry Flour 200 g
                                                    </h6>
                                                </a>

                                                <h5 class="sold text-content">
                                                    <span class="theme-color price">$26.69</span>
                                                    <del>28.56</del>
                                                </h5>
                                            </div>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="product-box product-box-bg wow fadeInUp">
                                            <div class="product-image">
                                                <a href="product-left-thumbnail.html">
                                                    <img src="../assets/images/cake/product/3.png"
                                                         class="img-fluid blur-up lazyload" alt="">
                                                </a>
                                            </div>
                                            <div class="product-detail">
                                                <a href="product-left-thumbnail.html">
                                                    <h6 class="name">Peanut Butter Bite Premium Butter Cookies 600 g
                                                    </h6>
                                                </a>

                                                <h5 class="sold text-content">
                                                    <span class="theme-color price">$26.69</span>
                                                    <del>28.56</del>
                                                </h5>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                            <div class="budle-list">
                                <ul>
                                    <li>
                                        <div class="form-check">
                                            <input class="checkbox_animated" type="checkbox" value="" id="check1">
                                            <label class="form-check-label" for="check1">
                                                <span class="color color-1"> Cupe-Cake 500 g
                                                    <span>$12</span></span>
                                            </label>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="form-check">
                                            <input class="checkbox_animated" type="checkbox" value="" id="check2">
                                            <label class="form-check-label" for="check2">
                                                <span class="color color-1"> Fresh Bread
                                                    <span>$15</span></span>
                                            </label>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="form-check">
                                            <input class="checkbox_animated" type="checkbox" value="" id="check3">
                                            <label class="form-check-label" for="check3">
                                                <span class="color color-1"> Black Forest
                                                    <span>$12</span></span>
                                            </label>
                                        </div>
                                    </li>

                                    <li class="contant">
                                        <h5>Product Selected for</h5>
                                        <h4 class="theme-color">$210.69 <del class="text-content">212.36</del></h4>
                                        <button class="btn text-white theme-bg-color btn-md mt-sm-4 mt-3 fw-bold"><i
                                                    class="fa-solid fa-cart-shopping me-2"></i> Add All To Cart</button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Related Product Section End -->

    <!-- Nav Tab Section Start -->
    <section>
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="product-section-box m-0">
                        <ul class="nav nav-tabs custom-nav" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="description-tab" data-bs-toggle="tab"
                                        data-bs-target="#description" type="button" role="tab" aria-controls="description"
                                        aria-selected="true">Description</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="info-tab" data-bs-toggle="tab" data-bs-target="#info"
                                        type="button" role="tab" aria-controls="info" aria-selected="false">Additional
                                    info</button>
                            </li>

                            {{--<li class="nav-item" role="presentation">
                                <button class="nav-link" id="care-tab" data-bs-toggle="tab" data-bs-target="#care"
                                        type="button" role="tab" aria-controls="care" aria-selected="false">Care
                                    Instuctions</button>
                            </li>--}}

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="review-tab" data-bs-toggle="tab" data-bs-target="#review"
                                        type="button" role="tab" aria-controls="review"
                                        aria-selected="false">Review</button>
                            </li>
                        </ul>

                        <div class="tab-content custom-tab" id="myTabContent">
                            <div class="tab-pane fade show active" id="description" role="tabpanel"
                                 aria-labelledby="description-tab">
                                <div class="product-description">

                                    {!! $product-> description!!}

                                </div>
                            </div>

                            <div class="tab-pane fade" id="info" role="tabpanel" aria-labelledby="info-tab">
                                <div class="table-responsive">
                                    <table class="table info-table">
                                        <tbody>
                                        @foreach($product->attributes as $product_attribute)
                                            <tr>
                                                <td>{{$product_attribute->attribute_name}}</td>
                                                <td>{{$product_attribute->value}}</td>
                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                           {{-- <div class="tab-pane fade" id="care" role="tabpanel" aria-labelledby="care-tab">
                                <div class="information-box">
                                    <ul>
                                        <li>Store cream cakes in a refrigerator. Fondant cakes should be
                                            stored in an air conditioned environment.</li>

                                        <li>Slice and serve the cake at room temperature and make sure
                                            it is not exposed to heat.</li>

                                        <li>Use a serrated knife to cut a fondant cake.</li>

                                        <li>Sculptural elements and figurines may contain wire supports
                                            or toothpicks or wooden skewers for support.</li>

                                        <li>Please check the placement of these items before serving to
                                            small children.</li>

                                        <li>The cake should be consumed within 24 hours.</li>

                                        <li>Enjoy your cake!</li>
                                    </ul>
                                </div>
                            </div>--}}

                            <div class="tab-pane fade" id="review" role="tabpanel" aria-labelledby="review-tab">
                                <div class="review-box">
                                    <div class="row g-4">
                                        <div class="col-xl-6">
                                            <div class="review-title">
                                                <h4 class="fw-500">Customer reviews</h4>
                                            </div>

                                            <div class="d-flex">
                                                <div class="product-rating">
                                                    {!! render_star_rating_for_front(round($product->reviews_avg_rate??0, 2)) !!}
                                                </div>
                                                <h6 class="ms-3">{{round($product->reviews_avg_rate??0, 2)}} Out Of 5 </h6>
                                            </div>

                                            <div class="rating-box">
                                                <ul>


                                                    <li>
                                                        <div class="rating-list">
                                                            <h5>5 Star</h5>
                                                            <div class="progress">
                                                                <div class="progress-bar" role="progressbar"
                                                                     style="width: {{$product->reviews->ratings_percentage[5]??0}}%" aria-valuenow="100"
                                                                     aria-valuemin="0" aria-valuemax="100">
                                                                    {{$product->reviews->ratings_percentage[5]??0}}%
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>

                                                    <li>
                                                        <div class="rating-list">
                                                            <h5>4 Star</h5>
                                                            <div class="progress">
                                                                <div class="progress-bar" role="progressbar"
                                                                     style="width: {{$product->reviews->ratings_percentage[4]??0}}%" aria-valuenow="100"
                                                                     aria-valuemin="0" aria-valuemax="100">
                                                                    {{$product->reviews->ratings_percentage[4]??0}}%
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>

                                                    <li>
                                                        <div class="rating-list">
                                                            <h5>3 Star</h5>
                                                            <div class="progress">
                                                                <div class="progress-bar" role="progressbar"
                                                                     style="width: {{$product->reviews->ratings_percentage[3]??0}}%" aria-valuenow="100"
                                                                     aria-valuemin="0" aria-valuemax="100">
                                                                    {{$product->reviews->ratings_percentage[3]??0}}%
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>

                                                    <li>
                                                        <div class="rating-list">
                                                            <h5>2 Star</h5>
                                                            <div class="progress">
                                                                <div class="progress-bar" role="progressbar"
                                                                     style="width: {{$product->reviews->ratings_percentage[2]??0}}%" aria-valuenow="100"
                                                                     aria-valuemin="0" aria-valuemax="100">
                                                                    {{$product->reviews->ratings_percentage[2]??0}}%
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>

                                                    <li>
                                                        <div class="rating-list">
                                                            <h5>1 Star</h5>
                                                            <div class="progress">
                                                                <div class="progress-bar" role="progressbar"
                                                                     style="width: {{$product->reviews->ratings_percentage[1]??0}}%" aria-valuenow="100"
                                                                     aria-valuemin="0" aria-valuemax="100">
                                                                    {{$product->reviews->ratings_percentage[1]??0}}%
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>

                                                </ul>
                                            </div>
                                        </div>

                                        <div class="col-xl-6">
                                            <div class="review-title">
                                                <h4 class="fw-500">Add a review</h4>
                                            </div>

                                            {!! render_validation_errors($errors) !!}

                                            <div class="row g-4">
                                                <form class="row g-4" method="post" action="{{route('customer.product.storeReview', $product->id)}}">
                                                    @csrf
                                                    <div class="col-md-6">
                                                        <div class="form-floating theme-form-floating">
                                                            <input type="number" class="form-control" id="review1"
                                                                   placeholder="Rate" max="5" min="0" name="rate" value="{{$current_user_review?->rate}}" required>
                                                            <label for="review1">Rate</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <div class="form-floating theme-form-floating">
                                                        <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 150px" name="comment">
                                                            {{$current_user_review?->comment}}
                                                        </textarea>
                                                            <label for="floatingTextarea2">Write Your Comment</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <div class="form-floating theme-form-floating">
                                                            <button type="submit" class="btn theme-bg-color text-white">Submit</button>
                                                        </div>
                                                    </div>




                                                </form>


                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="review-title">
                                                <h4 class="fw-500">Customer questions & answers</h4>
                                            </div>

                                            <div class="review-people">
                                                <ul class="review-list">
                                                    @foreach($product->reviews as $review)
                                                        <li>
                                                            <div class="people-box">
                                                                <div>
                                                                    <div class="people-image">
                                                                        <img src="{{$review->user->avatar}}"
                                                                             class="img-fluid blur-up lazyload" alt="">
                                                                    </div>
                                                                </div>

                                                                <div class="people-comment">
                                                                    <a class="name" href="javascript:void(0)">{{$review->user->full_name}}</a>
                                                                    <div class="date-time">
                                                                        <h6 class="text-content">{{$review->updated_at}}
                                                                        </h6>

                                                                        <div class="product-rating">
                                                                            {!! render_star_rating_for_front($review->rate) !!}

                                                                        </div>
                                                                    </div>

                                                                    <div class="reply">
                                                                        <p>{{$review->comment}}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endforeach





                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Nav Tab Section End -->

    <!-- Releted Product Section Start -->
    <section class="product-list-section section-b-space">
        <div class="container-fluid-lg">
            <div class="title">
                <h2>Related Products</h2>
                <span class="title-leaf">
                    <svg class="icon-width">
                        <use xlink:href="{{asset('frontend')}}/assets/svg/leaf.svg#leaf"></use>
                    </svg>
                </span>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="slider-6_1 product-wrapper">
                        @foreach($product->related_products as $related_product)
                            <div>
                                <div class="product-box-3 wow fadeInUp" data-wow-delay="{{$loop->index * 0.5}}s">
                                    <div class="product-header">
                                        <div class="product-image">
                                            <a href="{{route('customer.PDP', $related_product->id)}}">
                                                <img src="{{$product->thumbnail->getFullUrl()}}"
                                                     class="img-fluid blur-up lazyload" alt="">
                                            </a>

                                            <ul class="product-option">
                                                <li data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                                    <a href="javascript:void(0)" data-bs-toggle="modal"
                                                       data-bs-target="#view">
                                                        <i data-feather="eye"></i>
                                                    </a>
                                                </li>

                                                <li data-bs-toggle="tooltip" data-bs-placement="top" title="Compare">
                                                    <a href="compare.html">
                                                        <i data-feather="refresh-cw"></i>
                                                    </a>
                                                </li>

                                                <li data-bs-toggle="tooltip" data-bs-placement="top" title="Wishlist">
                                                    <a href="wishlist.html" class="notifi-wishlist">
                                                        <i data-feather="heart"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="product-footer">
                                        <div class="product-detail">
                                            <span class="span-name">{{$related_product->categories->first()->name ?? null}}</span>
                                            <a href="{{route('customer.PDP', $related_product->id)}}">
                                                <h5 class="name">{{$related_product->name}}</h5>
                                            </a>


                                            <div class="product-rating mt-2">
                                                <ul class="rating">
                                                    {!! render_star_rating_for_front(round($related_product->reviews_avg_rate??0, 2) ?? 0) !!}
                                                </ul>
                                                <span>({{round($related_product->reviews_avg_rate??0, 2) ?? 0}})</span>
                                            </div>
{{--                                            <h6 class="unit">500 G</h6>--}}
                                            <h5 class="price"><span class="theme-color">${{$related_product->price}}</span> {{--<del>$12.57</del>--}}
                                            </h5>
                                            <div class="add-to-cart-box bg-white">
                                                <button class="btn btn-add-cart addcart-button">Add
                                                    <span class="add-icon bg-light-gray">
                                                    <i class="fa-solid fa-plus"></i>
                                                </span>
                                                </button>
                                                <div class="cart_qty qty-box">
                                                    <div class="input-group bg-white">
                                                        <button type="button" class="qty-left-minus bg-gray"
                                                                data-type="minus" data-field="">
                                                            <i class="fa fa-minus" aria-hidden="true"></i>
                                                        </button>
                                                        <input class="form-control input-number qty-input" type="text"
                                                               name="quantity" value="0">
                                                        <button type="button" class="qty-right-plus bg-gray"
                                                                data-type="plus" data-field="">
                                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Releted Product Section End -->

    <!-- Add to cart Modal Start -->
    <div class="add-cart-box">
        <div class="add-iamge">
            <img src="{{asset('frontend/assets/images/cake/pro/1.jpg')}}" class="img-fluid" alt="">
        </div>

        <div class="add-contain">
            <h6>Added to Cart</h6>
        </div>
    </div>
    <!-- Add to cart Modal End -->

    <!-- Sticky Cart Box Start -->
    <div class="sticky-bottom-cart">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="cart-content">
                        <div class="product-image">
                            <img src="../assets/images/product/category/1.jpg" class="img-fluid blur-up lazyload"
                                 alt="">
                            <div class="content">
                                <h5>Creamy Chocolate Cake</h5>
                                <h6>$32.96<del class="text-danger">$96.00</del><span>55% off</span></h6>
                            </div>
                        </div>
                        <div class="selection-section">
                            <div class="form-group mb-0">
                                <select id="input-state" class="form-control form-select">
                                    <option selected disabled>Choose Weight...</option>
                                    <option>1/2 KG</option>
                                    <option>1 KG</option>
                                    <option>1.5 KG</option>
                                </select>
                            </div>
                            <div class="cart_qty qty-box product-qty m-0">
                                <div class="input-group h-100">
                                    <button type="button" class="qty-left-minus" data-type="minus" data-field="">
                                        <i class="fa fa-minus" aria-hidden="true"></i>
                                    </button>
                                    <input class="form-control input-number qty-input" type="text" name="quantity"
                                           value="1">
                                    <button type="button" class="qty-right-plus" data-type="plus" data-field="">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="add-btn">
                            <a class="btn theme-bg-color text-white wishlist-btn" href="wishlist.html"><i
                                        class="fa fa-bookmark"></i> Wishlist</a>
                            <a class="btn theme-bg-color text-white" href="cart.html"><i
                                        class="fas fa-shopping-cart"></i> Add To Cart</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Sticky Cart Box End -->



@endsection


@push('scripts')


    <!-- jquery ui-->
    <script src="{{asset('frontend')}}/assets/js/jquery-ui.min.js"></script>

    <!-- Bootstrap js-->
    <script src="{{asset('frontend')}}/assets/js/bootstrap/bootstrap-notify.min.js"></script>

    <!-- Slick js-->
    <script src="{{asset('frontend')}}/assets/js/custom-slick-animated.js"></script>

    <!-- Price Range Js -->
    <script src="{{asset('frontend')}}/assets/js/ion.rangeSlider.min.js"></script>

    <!-- sidebar open js -->
    <script src="{{asset('frontend')}}/assets/js/filter-sidebar.js"></script>

    <!-- Quantity js -->
    <script src="{{asset('frontend')}}/assets/js/quantity-2.js"></script>

    <!-- Zoom Js -->
    <script src="{{asset('frontend')}}/assets/js/jquery.elevatezoom.js"></script>
    <script src="{{asset('frontend')}}/assets/js/zoom-filter.js"></script>

    <!-- Sticky-bar js -->
    <script src="{{asset('frontend')}}/assets/js/sticky-cart-bottom.js"></script>

    <!-- Timer Js -->
    <script src="{{asset('frontend')}}/assets/js/timer1.js"></script>

    <!-- WOW js -->
    <script src="{{asset('frontend')}}/assets/js/wow.min.js"></script>
    <script src="{{asset('frontend')}}/assets/js/custom-wow.js"></script>

@endpush
