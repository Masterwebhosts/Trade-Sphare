<nav x-data="{ open: false }" class="md:hidden bg-white border-b">

    {{-- TOP BAR --}}
    <div class="px-4 py-3 flex justify-between items-center">

        <div class="font-bold text-sm">
            {{ config('app.name') }}
        </div>

        <button @click="open = !open" class="text-2xl">
            ☰
        </button>

    </div>

    {{-- MENU --}}
    <div x-show="open"
         x-transition
         class="border-t px-4 py-2 space-y-1 text-sm bg-white">

        @foreach($menu as $item)
            <a href="{{ route($item['route']) }}"
               class="block py-2"
               @click="open = false">
                {{ $item['label'] }}
            </a>
        @endforeach

        <a href="{{ route('profile.edit') }}" class="block py-2" @click="open = false">
            الملف الشخصي
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="text-red-600 w-full text-right py-2">
                تسجيل الخروج
            </button>
        </form>

    </div>

</nav>
