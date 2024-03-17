<?php


if(!function_exists('translate')){
    function translate(?string $value): ?string
    {
        return $value;
    }
}


if(!function_exists('customer_home_page_url')){
    function customer_home_page_url():string{
        return '/';
    }
}

if(!function_exists('admin_home_page_url')){
    function admin_home_page_url():string{
        return '/admin';
    }
}

if(!function_exists('home_page_url')){
    function home_page_url():string {
        if(!Auth::user() || Auth::user()->hasRole('customer')){
            return customer_home_page_url();
        }
        else {
            return admin_home_page_url();
        }
    }
}

if(!function_exists('settings')) {
    function settings(string $settingClass) {
        return  app($settingClass);
    }
}

if(!function_exists('render_star_rating')) {
     function render_star_rating(int $rate){
        $stars='';
        for ($index=1; $index <=5; $index++){
            if($index <= $rate){
                $stars.= '<i class="fa-solid fa-star" style="color: #FFAE00FF;"></i>';
            }else{
                $stars.= '<i class="fa-regular fa-star" style="color: #FFAE00FF;"></i>';
            }
        }

        return
            "<div class='flex flex-row-reverse justify-center p-10'>
               {$stars}
            </di"
            ;
    }
}

if(!function_exists('render_star_rating_for_front')) {
     function render_star_rating_for_front(int|float $rate){
        $stars='';
        for ($index=1; $index <=5; $index++){
            if($index <= $rate){
                $stars.= "<li><i data-feather='star' class='fill'></i></li>";

            }else{
                $stars.= "<li><i data-feather='star' ></i></li>";
            }
        }

        return
            "<ul class='rating'>
                {$stars}
            </ul>";
    }
}

if(!function_exists('render_validation_errors')) {
    function render_validation_errors($errors)
    {
        if($errors->any()){
            $msg = '<div class="alert alert-danger" role="alert">';

            foreach($errors->all() as $error) {
                $msg .= "<div> * {$error}</div>";
            }

            $msg .= '</div>';

            return $msg;
        }
        return '';
    }
}

if(!function_exists('get_locale_currency_code')) {
    function get_locale_currency_code()
    {
      return session(
          'currency_code',
          config('app.default_currency')
      );
    }
}

if(!function_exists('localize_price')) {
    function localize_price(float|int $price)
    {
       return \App\Services\ProductPriceService::localizePrice($price);
    }
}

