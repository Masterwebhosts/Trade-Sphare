<nav class="space-y-2 text-sm flex-1">

    <a href="{{ route('publisher.dashboard') }}"
       class="block px-3 py-2 rounded hover:bg-gray-100">
        لوحة التحكم
    </a>

    <a href="{{ route('publisher.zones.index') }}"
       class="block px-3 py-2 rounded hover:bg-gray-100">
        مناطق الإعلانات
    </a>

    <a href="{{ route('publisher.earnings.index') }}"
       class="block px-3 py-2 rounded hover:bg-gray-100">
        الأرباح
    </a>

    <a href="{{ route('publisher.wallet.index') }}"
       class="block px-3 py-2 rounded hover:bg-gray-100">
        المحفظة
    </a>

    <a href="{{ route('publisher.withdrawals.index') }}"
       class="block px-3 py-2 rounded hover:bg-gray-100">
        السحوبات
    </a>

    <a href="{{ route('profile.edit') }}"
       class="block px-3 py-2 rounded hover:bg-gray-100">
        الملف الشخصي
    </a>

    <form method="POST" action="{{ route('logout') }}">
        @csrf

        <button type="submit"
                class="w-full text-right px-3 py-2 rounded text-red-600 hover:bg-red-50">
            تسجيل الخروج
        </button>

    </form>

</nav>
