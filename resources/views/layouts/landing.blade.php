<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">


<title>
@yield('title','Trade Sphare | منصة إعلانية متكاملة')
</title>



<meta name="description" content="
أعلاني منصة إعلانية متكاملة تساعد الشركات والأفراد على إنشاء الحملات الإعلانية والوصول للعملاء ومتابعة الأداء والأرباح.
">



<meta name="keywords" content="
إعلانات,
تسويق رقمي,
حملات إعلانية,
إعلانات سوريا,
منصة إعلانية,
أعلاني
">



<meta name="author" content="Trade Sphare">



<meta property="og:title" content="Trade Sphare | منصة إعلانية متكاملة">

<meta property="og:description"
content="إدارة حملاتك الإعلانية والوصول إلى العملاء المناسبين من مكان واحد.">

<meta property="og:type" content="website">

<meta property="og:image"
content="{{ asset('assets/images/logo.png') }}">

<meta property="og:url"
content="{{ url('/') }}">



<meta name="twitter:card" content="summary_large_image">

<meta name="twitter:title"
content="Trade Sphare | منصة إعلانية">


<meta name="twitter:image"
content="{{ asset('assets/images/logo.png') }}">



{{-- FAVICON --}}

<link rel="icon" type="image/png" sizes="96x96"
      href="{{ asset('icons/favicon-96x96.png') }}">

<link rel="icon" type="image/svg+xml"
      href="{{ asset('icons/favicon.svg') }}">

<link rel="shortcut icon"
      href="{{ asset('icons/favicon.ico') }}">


<link rel="apple-touch-icon" sizes="180x180"
      href="{{ asset('icons/apple-touch-icon.png') }}">


<meta name="theme-color" content="#2563eb">



<link rel="stylesheet"
href="{{ asset('css/landing.css') }}">


<link rel="stylesheet"
href="{{ asset('css/navbar.css') }}">


<link rel="stylesheet"
href="{{ asset('css/sections.css') }}">


<link rel="stylesheet"
href="{{ asset('css/responsive.css') }}">


<link rel="stylesheet"
href="{{ asset('css/whatsapp.css') }}">


@stack('styles')


</head>


<body>


<div class="bg"></div>


@include('partials.navbar')



<main>

@yield('content')

</main>



@include('partials.footer')

@include('partials.whatsapp')

@include('partials.scripts')


@stack('scripts')


</body>

</html>