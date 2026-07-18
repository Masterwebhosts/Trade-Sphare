<body class="bg-gray-100 text-gray-900">

<div class="min-h-screen flex">

    {{-- SIDEBAR --}}
    <aside class="hidden md:flex w-64 bg-black text-white border-l border-gray-800 flex-col">

        {{-- HEADER --}}
        <div class="px-5 py-6 border-b border-gray-800">
            <h2 class="text-xl font-bold">
                لوحة المعلن
            </h2>
        </div>

        {{-- MENU --}}
        <nav class="flex-1 px-5 py-4 space-y-2 text-sm">

            <a href="{{ route('advertiser.dashboard') }}"
               class="block px-3 py-2 rounded hover:bg-gray-800 transition">
                لوحة التحكم
            </a>

            <a href="{{ route('advertiser.campaigns.index') }}"
               class="block px-3 py-2 rounded hover:bg-gray-800 transition">
                الحملات الإعلانية
            </a>

            <a href="{{ route('advertiser.campaigns.create') }}"
               class="block px-3 py-2 rounded hover:bg-gray-800 transition">
                إنشاء حملة
            </a>

            <a href="{{ route('advertiser.ads.index') }}"
               class="block px-3 py-2 rounded hover:bg-gray-800 transition">
                الإعلانات
            </a>

            <a href="{{ route('advertiser.ads.create') }}"
               class="block px-3 py-2 rounded hover:bg-gray-800 transition">
                إنشاء إعلان
            </a>

            <a href="{{ route('advertiser.stats.index') }}"
               class="block px-3 py-2 rounded hover:bg-gray-800 transition">
                الإحصائيات
            </a>

            <a href="{{ route('advertiser.topup.create') }}"
               class="block px-3 py-2 rounded hover:bg-gray-800 transition">
                المحفظة / شحن الرصيد
            </a>

        </nav>

        {{-- FOOTER --}}
        <div class="border-t border-gray-700 px-5 py-4 space-y-2">

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
