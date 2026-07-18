@extends('layouts.app')

@section('content')

<div class="p-6 space-y-6">

    <div class="flex justify-between items-center">

        <div>
            <h1 class="text-2xl font-bold text-gray-900">
                إدارة طلبات السحب
            </h1>

            <p class="text-gray-500 text-sm">
                مراجعة ومعالجة طلبات السحب الخاصة بالناشرين
            </p>
        </div>

    </div>

    {{-- FLASH --}}
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 p-4 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-lg">
            <ul class="list-disc ml-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    {{-- SUMMARY (مصدرها من Controller) --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

        <div class="bg-white rounded-xl shadow p-5">
            <div class="text-gray-500 text-sm">إجمالي الطلبات</div>
            <div class="text-2xl font-bold">{{ $summary['total'] ?? 0 }}</div>
        </div>

        <div class="bg-white rounded-xl shadow p-5">
            <div class="text-gray-500 text-sm">قيد الانتظار</div>
            <div class="text-2xl font-bold text-yellow-600">
                {{ $summary['pending'] ?? 0 }}
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-5">
            <div class="text-gray-500 text-sm">تمت الموافقة</div>
            <div class="text-2xl font-bold text-green-600">
                {{ $summary['approved'] ?? 0 }}
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-5">
            <div class="text-gray-500 text-sm">مرفوضة</div>
            <div class="text-2xl font-bold text-red-600">
                {{ $summary['rejected'] ?? 0 }}
            </div>
        </div>

    </div>


    {{-- TABLE --}}
    <div class="bg-white rounded-xl shadow overflow-x-auto">

        <table class="w-full text-sm">

            <thead class="bg-gray-50 border-b text-gray-600">
                <tr>
                    <th class="p-3 text-right">#</th>
                    <th class="p-3 text-right">الناشر</th>
                    <th class="p-3 text-right">المبلغ</th>
                    <th class="p-3 text-right">الحالة</th>
                    <th class="p-3 text-right">تاريخ الطلب</th>
                    <th class="p-3 text-right">تاريخ المعالجة</th>
                    <th class="p-3 text-left">الإجراءات</th>
                </tr>
            </thead>

            <tbody>

            @forelse($withdrawals as $w)

                @php
                    $status = strtolower($w->status);

                    $badge = [
                        'pending'  => 'bg-yellow-100 text-yellow-700',
                        'approved' => 'bg-green-100 text-green-700',
                        'rejected' => 'bg-red-100 text-red-700',
                        'paid'     => 'bg-blue-100 text-blue-700',
                    ];
                @endphp

                <tr class="border-b hover:bg-gray-50">

                    <td class="p-3 font-medium">
                        #{{ $w->id }}
                    </td>

                    <td class="p-3">
                        <div class="font-medium">
                        {{ $w->wallet->owner->name ?? 'مستخدم غير معروف' }}
                        </div>
                        <div class="text-xs text-gray-500">
                            Wallet ID: {{ $w->wallet_id }}
                        </div>
                    </td>

                    <td class="p-3 font-semibold">
                        ${{ number_format($w->amount, 2) }}
                    </td>

                    <td class="p-3">
                        <span class="px-2 py-1 rounded text-xs {{ $badge[$status] ?? 'bg-gray-100 text-gray-700' }}">
                            {{ ucfirst($w->status) }}
                        </span>
                    </td>

                    <td class="p-3 text-gray-500">
                        {{ $w->created_at?->format('Y-m-d H:i') }}
                    </td>

                    <td class="p-3 text-gray-500">
                        {{ $w->processed_at?->format('Y-m-d H:i') ?? '-' }}
                    </td>

                    <td class="p-3 text-left">

                        @if($w->status === 'pending')

                            <div class="flex gap-2 justify-end">

                                <form method="POST"
                                      action="{{ route('admin.withdrawals.approve', $w) }}">
                                    @csrf
                                    <button type="submit"
                                            onclick="return confirm('هل تريد الموافقة على طلب السحب؟')"
                                            class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">
                                        موافقة
                                    </button>
                                </form>

                                <form method="POST"
                                      action="{{ route('admin.withdrawals.reject', $w) }}">
                                    @csrf
                                    <button type="submit"
                                            onclick="return confirm('هل تريد رفض طلب السحب؟')"
                                            class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                                        رفض
                                    </button>
                                </form>

                            </div>

                        @else
                            <span class="text-xs text-gray-400">
                                تمت المعالجة
                            </span>
                        @endif

                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="7" class="p-8 text-center text-gray-500">
                        لا توجد طلبات سحب حالياً
                    </td>
                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

    {{-- PAGINATION --}}
    <div>
        {{ $withdrawals->links() }}
    </div>

</div>

@endsection