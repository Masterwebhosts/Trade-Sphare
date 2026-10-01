<x-guest-layout>

    <!-- حالة الجلسة -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- البريد الإلكتروني -->
        <div>
            <x-input-label for="email" value="البريد الإلكتروني" />

            <x-text-input
                id="email"
                class="block mt-1 w-full"
                type="email"
                name="email"
                :value="old('email')"
                required
                autofocus
                autocomplete="username"
            />

            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- كلمة المرور -->
        <div class="mt-4">
            <x-input-label for="password" value="كلمة المرور" />

            <div style="position: relative;">
                <x-text-input
                    id="password"
                    class="block mt-1 w-full"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    style="padding-left: 45px;"
                />

                <button
                    type="button"
                    id="toggle-password"
                    aria-label="إظهار كلمة المرور"
                    style="
                        position: absolute;
                        left: 10px;
                        top: 50%;
                        transform: translateY(-50%);
                        background: none;
                        border: 0;
                        padding: 4px;
                        cursor: pointer;
                        font-size: 18px;
                        line-height: 1;
                    "
                >👁</button>
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- تذكرني -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input
                    id="remember_me"
                    type="checkbox"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                    name="remember"
                >

                <span class="ms-2 text-sm text-gray-600">
                    تذكرني
                </span>
            </label>
        </div>

        <!-- الإجراءات -->
        <div class="flex items-center justify-end mt-4">

            @if (Route::has('password.request'))
                <a
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('password.request') }}"
                >
                    نسيت كلمة المرور؟
                </a>
            @endif

            <x-primary-button class="ms-3">
                تسجيل الدخول
            </x-primary-button>

        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const button = document.getElementById('toggle-password');
            const password = document.getElementById('password');

            if (!button || !password) {
                return;
            }

            button.addEventListener('click', function () {
                const isHidden = password.type === 'password';

                password.type = isHidden ? 'text' : 'password';
                button.textContent = isHidden ? '🙈' : '👁';
                button.setAttribute(
                    'aria-label',
                    isHidden ? 'إخفاء كلمة المرور' : 'إظهار كلمة المرور'
                );
            });
        });
    </script>

</x-guest-layout>
