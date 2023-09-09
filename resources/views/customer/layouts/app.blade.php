<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">

<head>
    @include('customer.layouts.includes.head')
    @yield('head')
</head>

<body>

    @include('customer.layouts.includes.loader')

    @include('customer.layouts.includes.header')


    @yield('content')



    @include('customer.layouts.includes.footer')

</body>

</html>
