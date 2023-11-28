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
    function home_page_url():string{
        if(Auth::user()->hasRole('super-admin')){
            return admin_home_page_url();
        }else {
            return customer_home_page_url();
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







