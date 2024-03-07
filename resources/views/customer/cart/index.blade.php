@extends('customer.layouts.app')

@section('head')
    <title>{{__('cart.page_title')}} </title>
@endsection


@push('style')
    <!-- slick css -->
    <link rel="stylesheet" type="text/css" href="{{asset('frontend')}}/assets/css/vendors/slick/slick.css">
    <link rel="stylesheet" type="text/css" href="{{asset('frontend')}}/assets/css/vendors/slick/slick-theme.css">
    <!-- Iconly css -->
    <link rel="stylesheet" type="text/css" href="{{asset('frontend')}}/assets/css/bulk-style.css">
@endpush


@section('content')

    <!-- Cart Section Start -->
    <section class="cart-section section-b-space">
        <div class="container-fluid-lg">
            <div class="row g-sm-5 g-3">
                <div class="col-xxl-9">
                    <div class="cart-table">
                        <div class="table-responsive-xl">
                            <table class="table">
                                <tbody>


                                @if(\Illuminate\Support\Facades\Auth::check())
                                    @foreach($cart as $cart_item)
                                        @php
                                            if($cart_item->product->has_special_price){
                                                if($cart_item->product->special_price_type=='percentage'){
                                                    $product_special_price_percentage = $cart_item->product->special_price;
                                                    $product_special_price = round($cart_item->product->price - (($product_special_price_percentage*$cart_item->product->price)/100.0), 2);
                                                }else{
                                                    // then $cart_item->product->special_price_type=='fixed'
                                                    $product_special_price_percentage = round(100*($cart_item->product->price - $cart_item->product->special_price) / ($cart_item->product->price==0 ? 100:$cart_item->product->price), 2);
                                                    $product_special_price = $cart_item->product->special_price;
                                                }
                                            }
                                        @endphp

                                        <tr class="product-box-contain">
                                            <td class="product-detail">
                                                <div class="product border-0">
                                                    <a href="{{route('customer.product.PDP', $cart_item->product_id)}}" class="product-image">
                                                        <img src="../assets/images/vegetable/product/1.png"
                                                             class="img-fluid blur-up lazyload" alt="">
                                                    </a>

                                                    <div class="product-detail">
                                                        <ul>
                                                            <li class="name">
                                                                <a href="{{route('customer.product.PDP', $cart_item->product_id)}}"> {{$cart_item->product->name??null}}  </a>
                                                            </li>

                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="price">
                                                <h4 class="table-title text-content">Price</h4>
                                                <h5>
                                                    ${{$cart_item->product->has_special_price? $product_special_price:$cart_item->product->price}}
                                                    {!!  $cart_item->product->has_special_price ?  "<del class='text-content'> \${$cart_item->product->price} </del>" :  ''!!}


                                                </h5>
{{--                                                <h6 class="theme-color">You Save : $20.68</h6>--}}
                                            </td>

                                            <td class="quantity">
                                                <h4 class="table-title text-content">Qty</h4>
                                                <div class="quantity-price">
                                                    <div class="cart_qty">
                                                        <div class="input-group">
                                                            <button type="button" class="btn qty-left-minus"
                                                                    data-type="minus" data-field=""
                                                                    data-form="{{json_encode([
                                                                                    'action'=> route('customer.cart.decreaseQty'),
                                                                                    'method' =>'post',
                                                                                    'input_fields'=> [
                                                                                            '_token'=> csrf_token(),
                                                                                            'qty'=> 1,
                                                                                            'product_id'=> $cart_item->product_id,
                                                                                        ]
                                                                                    ])}}"
                                                            >
                                                                <i class="fa fa-minus ms-0" aria-hidden="true"></i>
                                                            </button>
                                                            <input class="form-control input-number qty-input" type="text"
                                                                   name="qty" value="{{$cart_item->qty}}">
                                                            <button type="button" class="btn qty-right-plus"
                                                                    data-type="plus" data-field=""
                                                                    data-form="{{json_encode([
                                                                                    'action'=> route('customer.cart.increaseQty'),
                                                                                    'method' =>'post',
                                                                                    'input_fields'=> [
                                                                                            '_token'=> csrf_token(),
                                                                                            'qty'=> 1,
                                                                                            'product_id'=> $cart_item->product_id,
                                                                                        ]
                                                                                    ])}}"
                                                            >
                                                                <i class="fa fa-plus ms-0" aria-hidden="true"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="subtotal">
                                                <h4 class="table-title text-content">Total</h4>
                                                <h5>  ${{($cart_item->product->has_special_price ? $product_special_price : $cart_item->product->price) * $cart_item->qty}}  </h5>
                                            </td>

                                            <td class="save-remove">
                                                <h4 class="table-title text-content">Action</h4>
{{--                                                <a class="save notifi-wishlist" href="javascript:void(0)">Save for later</a>--}}
                                                <a class="remove close_button" href="javascript:void(0)">Remove</a>
                                            </td>
                                        </tr>
                                    @endforeach

                                 @else
                                    @foreach($cart as $product)
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

                                        <tr class="product-box-contain">
                                            <td class="product-detail">
                                                <div class="product border-0">
                                                    <a href="{{route('customer.product.PDP', $product->id)}}" class="product-image">
                                                        <img src="../assets/images/vegetable/product/1.png"
                                                             class="img-fluid blur-up lazyload" alt="">
                                                    </a>

                                                    <div class="product-detail">
                                                        <ul>
                                                            <li class="name">
                                                                <a href="{{route('customer.product.PDP', $product->id)}}"> {{$product->name??null}}  </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="price">
                                                <h4 class="table-title text-content">Price</h4>
                                                <h5>
                                                    ${{$product->has_special_price? $product_special_price:$product->price}}
                                                    {!!  $product->has_special_price ?  "<del class='text-content'> \${$product->price} </del>" :  ''!!}


                                                </h5>
                                                {{--                                                <h6 class="theme-color">You Save : $20.68</h6>--}}
                                            </td>

                                            <td class="quantity">
                                                <h4 class="table-title text-content">Qty</h4>
                                                <div class="quantity-price">
                                                    <div class="cart_qty">
                                                        <div class="input-group">
                                                            <button type="button" class="btn qty-left-minus"
                                                                    data-type="minus" data-field=""
                                                                    data-form="{{json_encode([
                                                                                    'action' => route('customer.cart.decreaseQty'),
                                                                                    'method' =>'post',
                                                                                    'input_fields' => [
                                                                                            '_token' => csrf_token(),
                                                                                            'qty' => 1,
                                                                                            'product_id' => $product->id,
                                                                                        ]
                                                                                    ])}}"
                                                            >

                                                                <i class="fa fa-minus ms-0" aria-hidden="true"></i>
                                                            </button>
                                                            <input class="form-control input-number qty-input" type="text"
                                                                   name="qty" value="{{$session_cart_product_qty[$product->id]}}">


                                                            <button type="button" class="btn qty-right-plus"
                                                                    data-type="plus" data-field=""
                                                                    data-form="{{json_encode([
                                                                                    'action'=> route('customer.cart.increaseQty'),
                                                                                    'method' =>'post',
                                                                                    'input_fields'=> [
                                                                                            '_token'=> csrf_token(),
                                                                                            'qty'=> 1,
                                                                                            'product_id'=> $product->id,
                                                                                        ]
                                                                                    ])}}"
                                                            >

                                                                <i class="fa fa-plus ms-0" aria-hidden="true"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="subtotal">
                                                <h4 class="table-title text-content">Total</h4>
                                                <h5>  ${{($product->has_special_price ? $product_special_price : $product->price) * $session_cart_product_qty[$product->id]}}  </h5>
                                            </td>

                                            <td class="save-remove">
                                                <h4 class="table-title text-content">Action</h4>
                                                {{--                                                <a class="save notifi-wishlist" href="javascript:void(0)">Save for later</a>--}}
                                                <a class="remove close_button" href="javascript:void(0)">Remove</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-3">
                    <div class="summery-box p-sticky">
                        <div class="summery-header">
                            <h3>Cart Total</h3>
                        </div>

                        <div class="summery-contain">
                            <div class="coupon-cart">
                                <h6 class="text-content mb-2">Coupon Apply</h6>
                                <div class="mb-3 coupon-box input-group">
                                    <input type="email" class="form-control" id="exampleFormControlInput1"
                                           placeholder="Enter Coupon Code Here...">
                                    <button class="btn-apply">Apply</button>
                                </div>
                            </div>
                            <ul>
                                <li>
                                    <h4>Subtotal</h4>
                                    <h4 class="price">$125.65</h4>
                                </li>

                                <li>
                                    <h4>Coupon Discount</h4>
                                    <h4 class="price">(-) 0.00</h4>
                                </li>

                                <li class="align-items-start">
                                    <h4>Shipping</h4>
                                    <h4 class="price text-end">$6.90</h4>
                                </li>
                            </ul>
                        </div>

                        <ul class="summery-total">
                            <li class="list-total border-top-0">
                                <h4>Total (USD)</h4>
                                <h4 class="price theme-color">$132.58</h4>
                            </li>
                        </ul>

                        <div class="button-group cart-button">
                            <ul>
                                <li>
                                    <button onclick="location.href = 'checkout.html';"
                                            class="btn btn-animation proceed-btn fw-bold">Process To Checkout</button>
                                </li>

                                <li>
                                    <button onclick="location.href = 'index.html';"
                                            class="btn btn-light shopping-button text-dark">
                                        <i class="fa-solid fa-arrow-left-long"></i>Return To Shopping</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Cart Section End -->

@endsection


@push('scripts')

    <!-- jquery ui-->
    <script src="{{asset('frontend')}}/assets/js/jquery-ui.min.js"></script>

    <script src="{{asset('frontend')}}/assets/js/bootstrap/bootstrap-notify.min.js"></script>

    <!-- Quantity js -->
    <script src="{{asset('frontend')}}/assets/js/quantity.js"></script>

@endpush

