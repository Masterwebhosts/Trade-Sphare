<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">


<title>
@yield('title','Trade Sphare | منصة إعلانية متكاملة')
</title>

<meta name="description" content="Trade Sphare منصة إعلانية رقمية تربط المعلنين بالناشرين، تساعد الشركات على إنشاء الحملات الإعلانية والوصول إلى العملاء المستهدفين، وتمكّن أصحاب المواقع والمحتوى من تحقيق الأرباح.">

<meta name="keywords" content="
Trade Sphare,
إعلانات سوريا,
منصة إعلانية,
الإعلان الرقمي,
حملات إعلانية,
تسويق رقمي,
ناشرين,
المعلنين,
الربح من المحتوى
">

<meta name="author" content="Trade Sphare">

<meta property="og:title" content="@yield('title','Trade Sphare | منصة إعلانية متكاملة')">

<meta property="og:description"
content="Trade Sphare منصة إعلانية تساعد المعلنين على الوصول إلى العملاء وتمكّن الناشرين من تحقيق دخل من محتواهم.">

<link rel="canonical" href="{{ url()->current() }}">

<meta property="og:type" content="website">

<meta property="og:image"
content="{{ asset('assets/images/logo.png') }}">

<meta property="og:url"
content="{{ url('/') }}">



<meta name="twitter:card" content="summary_large_image">

<meta name="twitter:title"
content="Trade Sphare | منصة إعلانية">

<meta name="twitter:description"
content="أنشئ حملات إعلانية واستفد من شبكة الناشرين مع Trade Sphare.">

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


<script type="application/ld+json">
{
 "@context":"https://schema.org",
 "@type":"Organization",
 "name":"Trade Sphare",
 "url":"https://tradesphare.com",
 "logo":"{{ asset('assets/images/logo.png') }}",
 "description":"منصة إعلانية رقمية تربط المعلنين بالناشرين.",
 "email":"info@tradesphare.com",
 "telephone":"+963932224359",
 "address":{
   "@type":"PostalAddress",
   "addressCountry":"SY"
 }
}
</script>

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