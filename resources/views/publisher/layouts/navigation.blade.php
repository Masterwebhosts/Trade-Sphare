<nav class="md:hidden bg-white border-b px-4 py-3 flex justify-between items-center">

    {{-- Logo --}}
    <div class="font-bold text-sm">
        {{ config('app.name', 'Sham Ads') }}
    </div>

    {{-- Mobile Menu (Publisher Links) --}}
    <div class="flex items-center gap-3 text-sm">

        @auth

            @if(auth()->user()->role === 'publisher')

                <a href="{{ route('publisher.dashboard') }}" class="text-gray-700">
                    الرئيسية
                </a>

                <a href="{{ route('publisher.zones.index') }}" class="text-gray-700">
                    المناطق
                </a>

                <a href="{{ route('publisher.wallet.index') }}" class="text-gray-700">
                    المحفظة
                </a>

            @endif

        @endauth

        {{-- Menu Button (future drawer) --}}
        <button class="text-2xl">
            ☰
        </button>

    </div>

</nav>
