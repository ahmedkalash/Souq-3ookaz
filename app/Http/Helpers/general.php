<?php




if(!function_exists('translate')){
    function translate(string $value){
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
        return '/adminq';
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





