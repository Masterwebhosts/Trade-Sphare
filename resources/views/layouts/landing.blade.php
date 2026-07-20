<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="manifest" href="{{ asset('manifest.json') }}">

<title>
@yield('title','أعلاني | منصة إعلانية متكاملة')
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


<meta name="author" content="أعلاني">



<!-- Open Graph -->

<meta property="og:title" content="أعلاني | منصة إعلانية متكاملة">


<meta property="og:description" content="
إدارة حملاتك الإعلانية والوصول إلى العملاء المناسبين من مكان واحد.
">


<meta property="og:type" content="website">


<meta property="og:image" content="{{ asset('assets/images/logo.png') }}">


<meta property="og:url" content="{{ url('/') }}">



<!-- Twitter -->

<meta name="twitter:card" content="summary_large_image">


<meta name="twitter:title" content="أعلاني | منصة إعلانية">


<meta name="twitter:description" content="
حلول إعلانية ذكية للشركات والأفراد.
">


<meta name="twitter:image" content="{{ asset('assets/images/logo.png') }}">



<!-- PWA -->

<link rel="manifest" href="{{ asset('manifest.json') }}">


<meta name="theme-color" content="#2563eb">


<link rel="apple-touch-icon" href="{{ asset('icons/icon-192.png') }}">



<!-- Favicon -->

<link rel="icon" href="{{ asset('assets/images/logo.png') }}">



<!-- CSS -->

<link rel="stylesheet" href="{{ asset('css/landing.css') }}">


@stack('styles')

<link rel="stylesheet" href="{{ asset('css/landing.css') }}">
<link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
<link rel="stylesheet" href="{{ asset('css/sections.css') }}">
<link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
<link rel="stylesheet" href="{{ asset('css/whatsapp.css') }}">

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