<?php




if(!function_exists('translate')){
    function translate(string $value){
        return $value;
    }
}


if(!function_exists('customerHomePageUrl')){
    function customerHomePageUrl():string{
        return '/';
    }
}


if(!function_exists('adminHomePageUrl')){
    function adminHomePageUrl():string{
        return '/adminq';
    }
}


if(!function_exists('homePageUrl')){
    function homePageUrl():string{
        if(Auth::user()->hasRole('super-admin')){
            return adminHomePageUrl();
        }else {
            return customerHomePageUrl();
        }
    }
}


