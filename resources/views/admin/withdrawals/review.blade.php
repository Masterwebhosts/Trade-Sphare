@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto p-6 space-y-6">

    <div class="flex items-center justify-between">

        <div>
            <h1 class="text-2xl font-bold text-gray-900">
                مراجعة طلب السحب
            </h1>

            <p class="text-gray-500 text-sm">
                طلب رقم #{{ $withdrawal->id }}
            </p>
        </div>

        <a href="{{ route('admin.withdrawals.index') }}"
           class="px-4 py-2 border rounded-lg hover:bg-gray-50 text-sm">
            رجوع
        </a>

    </div>

    {{-- SUCCESS --}}
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 p-4 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    {{-- ERRORS --}}
    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-lg">
            <ul class="list-disc ml-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border">

        <div class="p-6 space-y-6">

            {{-- REQUEST ID --}}
            <div>
                <div class="text-sm text-gray-500">معرف الطلب</div>
                <div class="font-semibold">#{{ $withdrawal->id }}</div>
            </div>

            {{-- USER --}}
<div>
    <div class="text-sm text-gray-500">الناشر</div>

    <div class="font-semibold">
        {{ optional($withdrawal->wallet->owner)->name ?? 'مستخدم غير معروف' }}
    </div>

    <div class="text-sm text-gray-500">
        Wallet ID: {{ $withdrawal->wallet_id }}
    </div>
</div>

            {{-- AMOUNT --}}
            <div>
                <div class="text-sm text-gray-500">المبلغ المطلوب</div>

                <div class="text-2xl font-bold text-blue-600">
                    ${{ number_format($withdrawal->amount, 2) }}
                </div>
            </div>

            {{-- STATUS --}}
            @php
                $status = strtolower($withdrawal->status);

                $badge = [
                    'pending'  => 'bg-yellow-100 text-yellow-700',
                    'approved' => 'bg-green-100 text-green-700',
                    'rejected' => 'bg-red-100 text-red-700',
                    'paid'     => 'bg-blue-100 text-blue-700',
                ];
            @endphp

            <div>
                <div class="text-sm text-gray-500 mb-2">الحالة</div>

                <span class="px-3 py-1 rounded text-sm {{ $badge[$status] ?? 'bg-gray-100 text-gray-700' }}">
                    {{ ucfirst($withdrawal->status) }}
                </span>
            </div>

            {{-- DATES --}}
            <div class="grid md:grid-cols-2 gap-6">

                <div>
                    <div class="text-sm text-gray-500">تاريخ الطلب</div>
                    <div>
                        {{ $withdrawal->created_at?->format('Y-m-d H:i:s') }}
                    </div>
                </div>

                <div>
                    <div class="text-sm text-gray-500">تاريخ المعالجة</div>
                    <div>
                        {{ $withdrawal->processed_at?->format('Y-m-d H:i:s') ?? '-' }}
                    </div>
                </div>

            </div>

            {{-- ACTIONS --}}
            @if($withdrawal->status === 'pending')

                <div class="border-t pt-6">

                    <div class="flex gap-3">

                        <form method="POST"
                              action="{{ route('admin.withdrawals.approve', $withdrawal) }}">
                            @csrf

                            <button type="submit"
                                    onclick="return confirm('تأكيد الموافقة على طلب السحب؟')"
                                    class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg">

                                موافقة

                            </button>
                        </form>

                        <form method="POST"
                              action="{{ route('admin.withdrawals.reject', $withdrawal) }}">
                            @csrf

                            <button type="submit"
                                    onclick="return confirm('تأكيد رفض طلب السحب؟')"
                                    class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-lg">

                                رفض

                            </button>
                        </form>

                    </div>

                </div>

            @else

                <div class="border-t pt-6">

                    <div class="bg-gray-50 border rounded-lg p-4 text-gray-600">

                        تم معالجة هذا الطلب مسبقاً.

                    </div>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection
