<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">


{{-- Favicon --}}

<link rel="icon" type="image/svg+xml" href="{{ asset('icons/favicon.svg') }}">

<link rel="icon" type="image/png" sizes="96x96" href="{{ asset('icons/favicon-96x96.png') }}">

<link rel="shortcut icon" href="{{ asset('icons/favicon.ico') }}">

<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('icons/apple-touch-icon.png') }}">


<title>{{ config('app.name', 'Trade Sphare') }}</title>


@vite([
    'resources/css/app.css',
    'resources/js/app.js'
])

    @include('partials.pwa')
</head>

<body class="bg-gray-100 text-gray-900">


@php
    $user = auth()->user();
    $role = $user?->role;
    $menu = config("navigation.$role", []);
@endphp


@include('layouts.navigation')


<div class="min-h-screen flex flex-row-reverse">


<aside class="hidden md:flex w-64 bg-black text-white flex-col min-h-screen">


<div class="p-5 flex-1">


<h2 class="text-xl font-bold mb-6 border-b border-gray-700 pb-3">

{{ match($role) {

'admin' => 'لوحة الإدارة',

'advertiser' => 'لوحة المعلن',

'publisher' => 'لوحة الناشر',

default => 'لوحة التحكم',

} }}

</h2>


<nav class="space-y-2">

@foreach($menu as $item)

@if(Route::has($item['route']))

<a href="{{ route($item['route']) }}"
class="block px-3 py-2 rounded hover:bg-gray-800">

{{ $item['label'] }}

</a>

@endif

@endforeach

</nav>


</div>


<div class="border-t border-gray-700 p-5">

<a href="{{ route('profile.edit') }}"
class="block px-3 py-2 rounded hover:bg-gray-800">

الملف الشخصي

</a>


<form method="POST" action="{{ route('logout') }}">

@csrf

<button class="w-full text-right px-3 py-2 rounded text-red-400">

تسجيل الخروج

</button>

</form>


</div>


</aside>



<main class="flex-1 p-6">

@yield('content')

</main>

</div>

</body>

</html>