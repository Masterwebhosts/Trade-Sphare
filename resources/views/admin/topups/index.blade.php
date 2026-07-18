@extends('layouts.app')

@section('content')

<div class="p-6 space-y-6">

    <h1 class="text-2xl font-bold">طلبات الشحن (Topups)</h1>

    <div class="bg-white shadow rounded-lg overflow-x-auto">

        <table class="w-full text-sm">

            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="p-3 text-right">#</th>
                    <th class="p-3 text-right">المحفظة</th>
                    <th class="p-3 text-right">المبلغ</th>
                    <th class="p-3 text-right">اسم الدافع</th>
                    <th class="p-3 text-right">طريقة الدفع</th>
                    <th class="p-3 text-right">الإيصال</th>
                    <th class="p-3 text-right">الحالة</th>
                    <th class="p-3 text-right">الإجراءات</th>
                </tr>
            </thead>

            <tbody>

            @forelse($topups as $tx)

                <tr class="border-b">

                    <td class="p-3">#{{ $tx->id }}</td>

                    <td class="p-3">{{ $tx->wallet_id }}</td>

                    <td class="p-3 font-semibold">
                        ${{ number_format($tx->amount, 2) }}
                    </td>

                    <td class="p-3">
                        {{ data_get($tx->meta, 'payer_name', '-') }}
                    </td>

                    <td class="p-3">
                        {{ data_get($tx->meta, 'payment_method', '-') }}
                    </td>

                    <td class="p-3">
                        @if(data_get($tx->meta, 'receipt'))
                            <a class="text-blue-600 underline"
                               href="{{ route('admin.topups.show', $tx->id) }}">
                                عرض
                            </a>
                        @else
                            -
                        @endif
                    </td>

                    {{-- 🔴 مهم جداً لإزالة الغموض --}}
                    <td class="p-3">
                        @if($tx->status === 'pending')
                            <span class="text-yellow-600">قيد المراجعة</span>
                        @elseif($tx->status === 'approved')
                            <span class="text-green-600">مقبول</span>
                        @else
                            <span class="text-red-600">مرفوض</span>
                        @endif
                    </td>

                    <td class="p-3 flex gap-2">

                        {{-- منع التكرار بعد القبول --}}
                        @if($tx->status === 'pending')

                            <form method="POST"
                                  action="{{ route('admin.topups.approve', $tx->id) }}">
                                @csrf
                                <button type="submit"
                                        class="bg-green-600 text-white px-3 py-1 rounded">
                                    قبول
                                </button>
                            </form>

                            <form method="POST"
                                  action="{{ route('admin.topups.reject', $tx->id) }}">
                                @csrf
                                <button type="submit"
                                        class="bg-red-600 text-white px-3 py-1 rounded">
                                    رفض
                                </button>
                            </form>

                        @else
                            <span class="text-gray-400 text-xs">تم المعالجة</span>
                        @endif

                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="8" class="p-6 text-center text-gray-500">
                        لا توجد طلبات شحن حالياً
                    </td>
                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection