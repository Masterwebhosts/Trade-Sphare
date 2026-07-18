<nav x-data="{ open: false }" class="md:hidden bg-white border-b">

    @php
        $user = auth()->user();
        $role = $user?->role;

        $menu = config("navigation.$role", []);
    @endphp

    <div class="px-4 py-3 flex items-center justify-between">

        <div class="font-bold">
            {{ config('app.name', 'Sham Ads') }}
        </div>

        <button @click="open = !open"
                class="text-2xl">
            ☰
        </button>

    </div>

    <div x-show="open"
         x-transition
         @click.away="open = false"
         class="border-t bg-white">

        <div class="p-3 space-y-1">

            @foreach($menu as $item)

                @if(Route::has($item['route']))
                    <a href="{{ route($item['route']) }}"
                       class="block px-3 py-2 rounded hover:bg-gray-100">
                        {{ $item['label'] }}
                    </a>
                @endif

            @endforeach

            <hr>

            <a href="{{ route('profile.edit') }}"
               class="block px-3 py-2 rounded hover:bg-gray-100">
                الملف الشخصي
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit"
                        class="w-full text-right px-3 py-2 text-red-600 rounded hover:bg-red-50">
                    تسجيل الخروج
                </button>
            </form>

        </div>

    </div>

</nav>
