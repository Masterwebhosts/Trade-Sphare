<aside class="hidden md:flex w-64 bg-black text-white min-h-screen flex flex-col p-6">

    {{-- TITLE --}}
    <h2 class="text-xl font-bold mb-6">
        لوحة التحكم الإدارية
    </h2>

    {{-- MENU --}}
    <nav class="space-y-2 text-sm flex-1">

        <a href="{{ route('admin.dashboard') }}"
           class="block p-2 rounded hover:bg-gray-800">
            لوحة التحكم
        </a>

        <a href="{{ route('admin.users.index') }}"
           class="block p-2 rounded hover:bg-gray-800">
            المستخدمون
        </a>

        <a href="{{ route('admin.campaigns.index') }}"
           class="block p-2 rounded hover:bg-gray-800">
            الحملات
        </a>

        <a href="{{ route('admin.ads.index') }}"
           class="block p-2 rounded hover:bg-gray-800">
            الإعلانات
        </a>

        <a href="{{ route('admin.topups.index') }}"
           class="block p-2 rounded hover:bg-gray-800">
            عمليات الشحن
        </a>

        <a href="{{ route('admin.finance.index') }}"
         class="block p-2 rounded hover:bg-gray-800">
          المالية
       </a>

        <a href="{{ route('admin.withdrawals.index') }}"
           class="block p-2 rounded hover:bg-gray-800">
            عمليات السحب
        </a>

        <a href="{{ route('admin.analytics.index') }}"
           class="block p-2 rounded hover:bg-gray-800">
            التحليلات
        </a>

        <a href="{{ route('admin.fraud.dashboard') }}"
        class="block p-2 rounded hover:bg-gray-800 text-yellow-300">
         تحليل الاحتيال
        </a>

        <a href="{{ route('management.dashboard') }}"
        class="block p-2 rounded hover:bg-gray-800 text-green-300">
        إدارة المنتجات والاشتراكات
        </a>
    </nav>

    {{-- FOOTER --}}
    <div class="border-t border-gray-700 pt-4 space-y-2">

        {{-- Profile --}}
        <a href="{{ route('profile.edit') }}"
           class="block p-2 rounded hover:bg-gray-800">
            الملف الشخصي
        </a>

        {{-- Logout --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit"
                    class="w-full text-right p-2 rounded text-red-400 hover:bg-gray-800">
                تسجيل الخروج
            </button>

        </form>

    </div>

</aside>
