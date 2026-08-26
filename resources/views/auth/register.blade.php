<x-guest-layout>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- الاسم -->
        <div>
            <x-input-label for="name" value="الاسم الكامل" />

            <x-text-input
                id="name"
                class="block mt-1 w-full"
                type="text"
                name="name"
                :value="old('name')"
                required
                autofocus
                autocomplete="name"
            />

            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- البريد الإلكتروني -->
        <div class="mt-4">
            <x-input-label for="email" value="البريد الإلكتروني" />

            <x-text-input
                id="email"
                class="block mt-1 w-full"
                type="email"
                name="email"
                :value="old('email')"
                required
                autocomplete="username"
            />

            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- كلمة المرور -->
        <div class="mt-4">
            <x-input-label for="password" value="كلمة المرور" />

            <x-text-input
                id="password"
                class="block mt-1 w-full"
                type="password"
                name="password"
                required
                autocomplete="new-password"
            />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- تأكيد كلمة المرور -->
        <div class="mt-4">
            <x-input-label
                for="password_confirmation"
                value="تأكيد كلمة المرور"
            />

            <x-text-input
                id="password_confirmation"
                class="block mt-1 w-full"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password"
            />

            <x-input-error
                :messages="$errors->get('password_confirmation')"
                class="mt-2"
            />
        </div>

        <!-- نوع الحساب -->
        <div class="mt-4">
            <x-input-label for="role" value="نوع الحساب" />

            <select
                id="role"
                name="role"
                required
                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
            >
                <option value="" disabled {{ old('role') ? '' : 'selected' }}>
                    اختر نوع الحساب
                </option>

                <option
                    value="advertiser"
                    {{ old('role') == 'advertiser' ? 'selected' : '' }}
                >
                    معلن (تشغيل الإعلانات)
                </option>

                <option
                    value="publisher"
                    {{ old('role') == 'publisher' ? 'selected' : '' }}
                >
                    ناشر (ربح المال)
                </option>
            </select>

            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

                <!-- الإجراءات -->
        <!-- الموافقة على الشروط والخصوصية -->
        <div class="mt-4">
            <label class="flex items-start gap-2">
                <input
                    type="checkbox"
                    name="legal_agreement"
                    value="1"
                    {{ old('legal_agreement') ? 'checked' : '' }}
                    required
                    class="mt-1 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                >
                <span class="text-sm text-gray-600 leading-6">
                    أوافق على
                    <a
                        href="https://tradesphare.com/blog/terms-of-use/"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="text-indigo-600 hover:text-indigo-800 underline"
                    >الشروط والأحكام</a>
                    و
                    <a
                        href="https://tradesphare.com/blog/privacy-policy/"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="text-indigo-600 hover:text-indigo-800 underline"
                    >سياسة الخصوصية</a>
                    الخاصة بمنصة Trade Sphare.
                </span>
            </label>
            <x-input-error :messages="$errors->get('legal_agreement')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">

            <a
                class="underline text-sm text-gray-600 hover:text-gray-900"
                href="{{ route('login') }}"
            >
                لديك حساب بالفعل؟
            </a>

            <x-primary-button class="ms-4">
                إنشاء حساب
            </x-primary-button>

        </div>

    </form>

</x-guest-layout>
