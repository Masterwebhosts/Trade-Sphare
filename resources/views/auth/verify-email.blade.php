<x-guest-layout>

    <div class="mb-4 text-sm text-gray-600">
        شكرًا لتسجيلك! قبل البدء، يرجى تأكيد بريدك الإلكتروني عبر الرابط الذي أرسلناه إليك.  
        إذا لم يصلك البريد، يمكنك طلب إعادة الإرسال.
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            تم إرسال رابط تحقق جديد إلى البريد الإلكتروني الذي استخدمته أثناء التسجيل.
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">

        <!-- إعادة إرسال رابط التحقق -->
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <x-primary-button>
                إعادة إرسال رابط التحقق
            </x-primary-button>
        </form>

        <!-- تسجيل الخروج -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit"
                class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                تسجيل الخروج
            </button>
        </form>

    </div>

</x-guest-layout>
