<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

{{-- PWA --}}

<link rel="manifest" href="{{ asset('manifest.webmanifest') }}">

<meta name="theme-color" content="#000000">

<meta name="mobile-web-app-capable" content="yes">

<meta name="apple-mobile-web-app-capable" content="yes">

<meta name="apple-mobile-web-app-status-bar-style" content="black">

<meta
    name="apple-mobile-web-app-title"
    content="{{ config('app.name', 'Trade Sphare') }}"
>

{{-- Favicon --}}

<link
    rel="icon"
    type="image/svg+xml"
    href="{{ asset('icons/favicon.svg') }}"
>

<link
    rel="icon"
    type="image/png"
    sizes="96x96"
    href="{{ asset('icons/favicon-96x96.png') }}"
>

<link
    rel="shortcut icon"
    href="{{ asset('icons/favicon.ico') }}"
>

<link
    rel="apple-touch-icon"
    sizes="180x180"
    href="{{ asset('icons/apple-touch-icon.png') }}"
>

<title>
    {{ config('app.name', 'Trade Sphare') }}
</title>

@vite([
    'resources/css/app.css',
    'resources/js/app.js'
])

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

                        <a
                            href="{{ route($item['route']) }}"
                            class="block px-3 py-2 rounded hover:bg-gray-800"
                        >
                            {{ $item['label'] }}
                        </a>

                    @endif

                @endforeach

            </nav>

        </div>

        <div class="border-t border-gray-700 p-5">

            <a
                href="{{ route('profile.edit') }}"
                class="block px-3 py-2 rounded hover:bg-gray-800"
            >
                الملف الشخصي
            </a>

            <form
                method="POST"
                action="{{ route('logout') }}"
            >

                @csrf

                <button
                    type="submit"
                    class="w-full text-right px-3 py-2 rounded text-red-400"
                >
                    تسجيل الخروج
                </button>

            </form>

        </div>

    </aside>

    <main class="flex-1 p-6">

        @yield('content')

    </main>

</div>


{{-- ========================================================= --}}
{{-- PWA INSTALL PROMPT --}}
{{-- ========================================================= --}}

<div
    id="pwa-install-prompt"
    class="hidden fixed inset-x-4 bottom-4 z-[9999] mx-auto max-w-md rounded-2xl bg-white p-5 shadow-2xl border border-gray-200"
    dir="rtl"
>

    <div class="flex items-start gap-4">

        <img
            src="{{ asset('icons/icon-192x192.png') }}"
            alt="Trade Sphare"
            class="w-14 h-14 rounded-xl"
        >

        <div class="flex-1">

            <h3 class="font-bold text-lg text-gray-900">
                ثبّت تطبيق Trade Sphare
            </h3>

            <p class="mt-1 text-sm text-gray-600">
                ثبّت التطبيق للوصول السريع إلى Trade Sphare من جهازك.
            </p>

        </div>

    </div>

    <div class="mt-4 flex gap-2">

        <button
            id="pwa-install-button"
            type="button"
            class="flex-1 rounded-xl bg-black px-4 py-3 text-sm font-bold text-white"
        >
            تثبيت التطبيق
        </button>

        <button
            id="pwa-dismiss-button"
            type="button"
            class="rounded-xl bg-gray-100 px-4 py-3 text-sm font-semibold text-gray-700"
        >
            إلغاء
        </button>

    </div>

</div>


{{-- ========================================================= --}}
{{-- PWA JAVASCRIPT --}}
{{-- ========================================================= --}}

<script>

    let deferredPrompt = null;

    const installPrompt =
        document.getElementById('pwa-install-prompt');

    const installButton =
        document.getElementById('pwa-install-button');

    const dismissButton =
        document.getElementById('pwa-dismiss-button');


    /*
    |--------------------------------------------------------------------------
    | Service Worker
    |--------------------------------------------------------------------------
    */

    if ('serviceWorker' in navigator) {

        window.addEventListener('load', () => {

            navigator.serviceWorker.register('/sw.js', {
                scope: '/'
            })

            .then((registration) => {

                console.log(
                    'Trade Sphare Service Worker registered:',
                    registration.scope
                );

            })

            .catch((error) => {

                console.error(
                    'Trade Sphare Service Worker registration failed:',
                    error
                );

            });

        });

    }


    /*
    |--------------------------------------------------------------------------
    | PWA Install Prompt
    |--------------------------------------------------------------------------
    */

    window.addEventListener(
        'beforeinstallprompt',
        (event) => {

            console.log(
                'Trade Sphare: beforeinstallprompt fired'
            );


            /*
             * منع Banner الافتراضي للمتصفح.
             */

            event.preventDefault();


            /*
             * حفظ حدث التثبيت لاستخدامه عند الضغط
             * على زر "تثبيت التطبيق".
             */

            deferredPrompt = event;


            /*
             * إظهار النافذة مباشرة.
             *
             * لا localStorage هنا.
             *
             * إلغاء:
             * تختفي النافذة.
             *
             * Refresh:
             * تظهر من جديد.
             */

            if (installPrompt) {

                installPrompt.classList.remove(
                    'hidden'
                );

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Install Button
    |--------------------------------------------------------------------------
    */

    if (installButton) {

        installButton.addEventListener(
            'click',
            async () => {

                if (!deferredPrompt) {

                    console.log(
                        'PWA install prompt is not available'
                    );

                    return;

                }


                try {

                    deferredPrompt.prompt();


                    const { outcome } =
                        await deferredPrompt.userChoice;


                    console.log(
                        'PWA install result:',
                        outcome
                    );


                } catch (error) {

                    console.error(
                        'PWA install error:',
                        error
                    );

                }


                deferredPrompt = null;


                if (installPrompt) {

                    installPrompt.classList.add(
                        'hidden'
                    );

                }

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Dismiss Button
    |--------------------------------------------------------------------------
    */

    if (dismissButton) {

        dismissButton.addEventListener(
            'click',
            () => {

                /*
                 * إخفاء مؤقت فقط.
                 *
                 * لا يتم تخزين أي شيء في localStorage.
                 */

                if (installPrompt) {

                    installPrompt.classList.add(
                        'hidden'
                    );

                }

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | App Installed
    |--------------------------------------------------------------------------
    */

    window.addEventListener(
        'appinstalled',
        () => {

            console.log(
                'Trade Sphare PWA installed'
            );


            deferredPrompt = null;


            if (installPrompt) {

                installPrompt.classList.add(
                    'hidden'
                );

            }

        }
    );

</script>

</body>
</html>

