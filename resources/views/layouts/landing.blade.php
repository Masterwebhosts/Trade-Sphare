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

{{-- PWA --}}

<link rel="manifest" href="{{ asset('manifest.webmanifest') }}">

<meta name="theme-color" content="#000000">

<meta name="mobile-web-app-capable" content="yes">

<meta name="apple-mobile-web-app-capable" content="yes">

<meta name="apple-mobile-web-app-status-bar-style" content="default">

<meta name="apple-mobile-web-app-title" content="Trade Sphare">

{{-- FAVICON --}}

<link rel="icon"
      type="image/png"
      sizes="96x96"
      href="{{ asset('icons/favicon-96x96.png') }}">

<link rel="icon"
      type="image/svg+xml"
      href="{{ asset('icons/favicon.svg') }}">

<link rel="shortcut icon"
      href="{{ asset('icons/favicon.ico') }}">

<link rel="apple-touch-icon"
      sizes="180x180"
      href="{{ asset('icons/apple-touch-icon.png') }}">

{{-- STYLES --}}

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

{{-- PWA INSTALL PROMPT --}}

<style>
    #pwa-install-prompt {
        position: fixed;
        left: 16px;
        right: 16px;
        bottom: 20px;
        z-index: 99999;

        width: auto;
        max-width: 420px;

        margin: 0 auto;

        padding: 18px;

        background: #ffffff;

        border: 1px solid #e5e7eb;
        border-radius: 18px;

        box-shadow:
            0 20px 45px rgba(0, 0, 0, 0.15);

        font-family:
            Arial,
            Tahoma,
            sans-serif;

        direction: rtl;

        box-sizing: border-box;
    }

    #pwa-install-prompt.hidden {
        display: none !important;
    }

    .pwa-install-content {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .pwa-install-icon {
        width: 56px !important;
        height: 56px !important;

        min-width: 56px;
        max-width: 56px;

        object-fit: cover;

        border-radius: 14px;

        display: block;
    }

    .pwa-install-text {
        flex: 1;
        min-width: 0;
    }

    .pwa-install-title {
        margin: 0;

        font-size: 17px;
        line-height: 1.5;

        font-weight: 700;

        color: #111827;
    }

    .pwa-install-description {
        margin: 4px 0 0;

        font-size: 13px;
        line-height: 1.7;

        color: #6b7280;
    }

    .pwa-install-actions {
        display: flex;

        gap: 8px;

        margin-top: 16px;
    }

    .pwa-install-button,
    .pwa-dismiss-button {
        border: 0;

        cursor: pointer;

        font-family: inherit;

        font-size: 14px;

        font-weight: 700;

        border-radius: 11px;

        padding: 11px 16px;

        transition:
            opacity 0.2s ease,
            transform 0.2s ease;
    }

    .pwa-install-button {
        flex: 1;

        background: #111827;

        color: #ffffff;
    }

    .pwa-dismiss-button {
        background: #f3f4f6;

        color: #374151;
    }

    .pwa-install-button:hover,
    .pwa-dismiss-button:hover {
        opacity: 0.85;
    }

    .pwa-install-button:active,
    .pwa-dismiss-button:active {
        transform: scale(0.98);
    }

    @media (max-width: 480px) {

        #pwa-install-prompt {
            left: 12px;
            right: 12px;
            bottom: 12px;

            padding: 16px;

            border-radius: 16px;
        }

        .pwa-install-icon {
            width: 52px !important;
            height: 52px !important;

            min-width: 52px;
            max-width: 52px;
        }

        .pwa-install-title {
            font-size: 16px;
        }

        .pwa-install-description {
            font-size: 12px;
        }

    }
</style>

<div
    id="pwa-install-prompt"
    class="hidden"
>

<div class="pwa-install-content">

    <img
        src="{{ asset('icons/icon-192x192.png') }}"
        alt="Trade Sphare"
        class="pwa-install-icon"
    >

    <div class="pwa-install-text">

        <h3 class="pwa-install-title">
            ثبّت تطبيق Trade Sphare
        </h3>

        <p class="pwa-install-description">
            ثبّت التطبيق للوصول السريع إلى Trade Sphare من جهازك.
        </p>

    </div>

</div>


<div class="pwa-install-actions">

    <button
        id="pwa-install-button"
        type="button"
        class="pwa-install-button"
    >
        تثبيت التطبيق
    </button>

    <button
        id="pwa-dismiss-button"
        type="button"
        class="pwa-dismiss-button"
    >
        إلغاء
    </button>
</div>


</div>

<script>

(function () {

    'use strict';


    /*
    |--------------------------------------------------------------------------
    | SERVICE WORKER
    |--------------------------------------------------------------------------
    */

    if ('serviceWorker' in navigator) {

        window.addEventListener('load', function () {

            navigator.serviceWorker.register('/sw.js', {
                scope: '/'
            })
            .then(function (registration) {

                console.log(
                    'Trade Sphare Service Worker registered:',
                    registration.scope
                );

            })
            .catch(function (error) {

                console.error(
                    'Trade Sphare Service Worker registration failed:',
                    error
                );

            });

        });

    }


    /*
    |--------------------------------------------------------------------------
    | PWA INSTALL PROMPT
    |--------------------------------------------------------------------------
    */

    let deferredPrompt = null;


    const installPrompt =
        document.getElementById('pwa-install-prompt');

    const installButton =
        document.getElementById('pwa-install-button');

    const dismissButton =
        document.getElementById('pwa-dismiss-button');


    if (
        !installPrompt ||
        !installButton ||
        !dismissButton
    ) {
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | BEFORE INSTALL PROMPT
    |--------------------------------------------------------------------------
    */

    window.addEventListener(
        'beforeinstallprompt',
        function (event) {

            console.log(
                'Trade Sphare: beforeinstallprompt fired'
            );


            /*
             * منع Banner الافتراضي للمتصفح
             * حتى نستخدم النافذة الخاصة بنا.
             */

            event.preventDefault();


            deferredPrompt = event;


            /*
             * إظهار النافذة مباشرة.
             *
             * لا يوجد localStorage هنا.
             * لذلك:
             *
             * إلغاء -> تختفي
             * Refresh -> تظهر من جديد
             */

            installPrompt.classList.remove('hidden');

        }
    );


    /*
    |--------------------------------------------------------------------------
    | INSTALL BUTTON
    |--------------------------------------------------------------------------
    */

    installButton.addEventListener(
        'click',
        async function () {

            if (!deferredPrompt) {

                console.log(
                    'Trade Sphare: install prompt is not available'
                );

                return;

            }


            try {

                deferredPrompt.prompt();


                const result =
                    await deferredPrompt.userChoice;


                console.log(
                    'Trade Sphare install result:',
                    result.outcome
                );


            } catch (error) {

                console.error(
                    'Trade Sphare install error:',
                    error
                );

            }


            deferredPrompt = null;

            installPrompt.classList.add('hidden');

        }
    );


    /*
    |--------------------------------------------------------------------------
    | DISMISS BUTTON
    |--------------------------------------------------------------------------
    */

    dismissButton.addEventListener(
        'click',
        function () {

            /*
             * إخفاء مؤقت فقط.
             *
             * لا localStorage.
             */

            installPrompt.classList.add('hidden');

        }
    );


    /*
    |--------------------------------------------------------------------------
    | APP INSTALLED
    |--------------------------------------------------------------------------
    */

    window.addEventListener(
        'appinstalled',
        function () {

            console.log(
                'Trade Sphare PWA installed successfully'
            );


            deferredPrompt = null;

            installPrompt.classList.add('hidden');

        }
    );


})();

</script>

@stack('scripts')

</body>

</html>
