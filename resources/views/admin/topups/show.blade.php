@extends('layouts.app')

@section('content')

<div class="container mx-auto p-6 space-y-6">

    <div class="flex items-center justify-between">

        <h2 class="text-2xl font-bold text-gray-900">
            طلب شحن الرصيد رقم #{{ $topup->id }}
        </h2>

        <a href="{{ route('admin.topups.index') }}"
           class="text-sm text-blue-600 hover:underline">
            ← رجوع
        </a>

    </div>

    <div class="bg-white rounded-xl shadow p-6 space-y-6">

        {{-- بيانات --}}
        <div class="grid md:grid-cols-2 gap-4 text-sm">

            <div>
                <div class="text-gray-500">المبلغ</div>
                <div class="font-semibold text-lg">
                    ${{ number_format($topup->amount, 2) }}
                </div>
            </div>

            <div>
                <div class="text-gray-500">الحالة</div>
                <div class="font-semibold">
                    {{ ucfirst($topup->status) }}
                </div>
            </div>

            <div>
                <div class="text-gray-500">اسم الدافع</div>
                <div class="font-semibold">
                    {{ data_get($topup->meta, 'payer_name', '-') }}
                </div>
            </div>

            <div>
                <div class="text-gray-500">طريقة الدفع</div>
                <div class="font-semibold">
                    {{ data_get($topup->meta, 'payment_method', '-') }}
                </div>
            </div>

        </div>

        {{-- الإيصال مع preview + zoom --}}
        <div class="pt-4 border-t">

            <div class="text-gray-500 mb-3">إيصال الدفع</div>

            @php
                $receipt = data_get($topup->meta, 'receipt');
            @endphp

            @if($receipt)

                <div class="flex justify-start">

                    <a href="{{ asset('storage/' . $receipt) }}"
                       target="_blank"
                       class="block">

                        <img
                            src="{{ asset('storage/' . $receipt) }}"
                            alt="receipt"
                            class="w-64 rounded-lg border shadow cursor-zoom-in hover:scale-105 transition duration-300"
                        >

                    </a>

                </div>

                <p class="text-xs text-gray-400 mt-2">
                    اضغط على الصورة لعرضها بالحجم الكامل
                </p>

            @else

                <p class="text-gray-400 text-sm">لا يوجد إيصال مرفوع</p>

            @endif

        </div>

        {{-- الإجراءات --}}
        @if($topup->status === 'pending')

            <div class="pt-6 border-t flex gap-3">

                <form method="POST"
                      action="{{ route('admin.topups.approve', $topup->id) }}">
                    @csrf
                    <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg">
                        قبول الطلب
                    </button>
                </form>

                <form method="POST"
                      action="{{ route('admin.topups.reject', $topup->id) }}">
                    @csrf
                    <button type="submit"
                            class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-lg">
                        رفض الطلب
                    </button>
                </form>

            </div>

        @else

            <div class="pt-6 border-t">

                <div class="bg-gray-50 border rounded-lg p-4 text-gray-600 text-sm">
                    تم معالجة هذا الطلب مسبقاً.
                </div>

            </div>

        @endif

    </div>

</div>

@endsection