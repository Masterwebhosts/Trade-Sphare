@extends('layouts.app')

@section('content')

<div dir="rtl" class="max-w-7xl mx-auto p-6 space-y-6 text-right">

    {{-- HEADER --}}
    <div>
        <h1 class="text-3xl font-bold text-gray-900">
            محفظة الناشر
        </h1>

        <p class="text-gray-500 mt-2">
            عرض الرصيد الحالي وسجل جميع العمليات المالية
        </p>
    </div>

    {{-- BALANCE CARD --}}
    <div class="bg-gradient-to-l from-green-600 to-emerald-500 text-white rounded-2xl shadow-lg p-8">

        <div class="text-sm opacity-80">
            الرصيد المتاح
        </div>

        <div class="text-5xl font-bold mt-2">
            ${{ number_format($wallet?->available_balance ?? 0, 6) }}
        </div>

        <div class="mt-3 text-sm opacity-75">
            يتم احتساب الرصيد تلقائياً من سجل القيود المالية
        </div>

    </div>

    {{-- TRANSACTIONS --}}
    <div class="bg-white rounded-2xl shadow overflow-hidden">

        <div class="p-5 border-b">
            <h2 class="text-lg font-semibold">
                سجل العمليات المالية
            </h2>
        </div>

        <div class="overflow-x-auto">

            <table class="min-w-full text-sm">

                <thead class="bg-gray-50 text-gray-600">

                    <tr>
                        <th class="p-4 text-right">النوع</th>
                        <th class="p-4 text-right">المبلغ</th>
                        <th class="p-4 text-right">المرجع</th>
                        <th class="p-4 text-right">التأثير</th>
                        <th class="p-4 text-right">التاريخ</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse($transactions as $entry)

                        @php
                            $isCredit = $entry->type === 'CREDIT';
                        @endphp

                        <tr class="border-b hover:bg-gray-50 transition">

                            {{-- TYPE --}}
                            <td class="p-4">

                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold
                                    {{ $isCredit
                                        ? 'bg-green-100 text-green-700'
                                        : 'bg-red-100 text-red-700' }}">
                                    {{ $isCredit ? 'إيداع' : 'خصم' }}
                                </span>

                            </td>

                            {{-- AMOUNT --}}
                            <td
                                class="p-4 font-bold
                                {{ $isCredit ? 'text-green-600' : 'text-red-600' }}">

                                {{ $isCredit ? '+' : '-' }}
                                ${{ number_format($entry->amount, 6) }}

                            </td>

                            {{-- REFERENCE --}}
                            <td class="p-4">

                                <div class="font-medium text-gray-800">
                                    {{ $entry->reference_type }}
                                </div>

                                <div class="text-xs text-gray-400">
                                    #{{ $entry->reference_id }}
                                </div>

                            </td>

                            {{-- IMPACT --}}
                            <td class="p-4">

                                <span
                                    class="{{ $isCredit ? 'text-green-600' : 'text-red-600' }}">

                                    {{ $isCredit
                                        ? 'زيادة في الرصيد'
                                        : 'خصم من الرصيد' }}

                                </span>

                            </td>

                            {{-- DATE --}}
                            <td class="p-4 text-gray-500 whitespace-nowrap">

                                {{ $entry->created_at?->format('Y/m/d') }}

                                <div class="text-xs text-gray-400 mt-1">
                                    {{ $entry->created_at?->format('H:i') }}
                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="5" class="p-12 text-center">

                                <div class="flex flex-col items-center gap-3">

                                    <svg class="w-12 h-12 text-gray-300"
                                         fill="none"
                                         stroke="currentColor"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="1.5"
                                              d="M12 8v4m0 4h.01M6.938 4h10.124c1.54 0 2.502 1.667 1.732 3L13.732 18c-.77 1.333-2.694 1.333-3.464 0L5.206 7c-.77-1.333.192-3 1.732-3z"/>
                                    </svg>

                                    <p class="text-gray-500">
                                        لا توجد عمليات مالية حتى الآن
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- PAGINATION --}}
        @if($transactions->count())
            <div class="p-5 border-t bg-gray-50">
                {{ $transactions->links() }}
            </div>
        @endif

    </div>

</div>

@endsection
