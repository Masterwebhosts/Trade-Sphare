<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>لوحة الناشر</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

<div class="min-h-screen flex flex-row-reverse">

    {{-- SIDEBAR --}}
    <aside class="hidden md:flex w-64 bg-black text-white border-l border-gray-800 flex-col min-h-screen">

        <div class="p-4 flex-1">

            <h2 class="text-xl font-bold mb-6">
                لوحة الناشر
            </h2>

            <nav class="space-y-1">

                <a href="{{ route('publisher.dashboard') }}"
                   class="block px-3 py-2 rounded hover:bg-gray-800 transition">
                    الرئيسية
                </a>

                <a href="{{ route('publisher.zones.index') }}"
                   class="block px-3 py-2 rounded hover:bg-gray-800 transition">
                    مناطق الإعلانات
                </a>

                <a href="{{ route('publisher.earnings.index') }}"
                   class="block px-3 py-2 rounded hover:bg-gray-800 transition">
                    الأرباح
                </a>

                <a href="{{ route('publisher.wallet.index') }}"
                   class="block px-3 py-2 rounded hover:bg-gray-800 transition">
                    المحفظة
                </a>

                <a href="{{ route('publisher.withdrawals.index') }}"
                   class="block px-3 py-2 rounded hover:bg-gray-800 transition">
                    السحوبات
                </a>

                <a href="{{ route('profile.edit') }}"
                   class="block px-3 py-2 rounded hover:bg-gray-800 transition">
                    الملف الشخصي
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit"
                            class="w-full text-right px-3 py-2 rounded text-red-400 hover:bg-gray-800 transition">
                        تسجيل الخروج
                    </button>

                </form>

            </nav>

        </div>

    </aside>

    {{-- MAIN --}}
    <div class="flex-1 flex flex-col">

        @include('layouts.navigation')

        <main class="flex-1 p-6">
            @yield('content')
        </main>

    </div>

</div>

</body>
</html>
