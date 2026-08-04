@extends('layouts.app')

@section('content')

<div dir="rtl" class="max-w-7xl mx-auto p-6 space-y-6 text-right">


    {{-- HEADER --}}
    <div>
        <h1 class="text-3xl font-bold text-gray-900">
            محفظة الناشر
        </h1>

        <p class="text-gray-500 mt-2">
            عرض الرصيد الحالي والأرباح وسجل العمليات المالية
        </p>
    </div>



    {{-- CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">


        <div class="bg-white rounded-2xl shadow p-5 border">
            <p class="text-gray-500 text-sm">الرصيد الحالي</p>
            <h3 class="text-2xl font-bold text-green-600 mt-2">
                ${{ number_format($balance ?? 0,2) }}
            </h3>
        </div>



        <div class="bg-white rounded-2xl shadow p-5 border">
            <p class="text-gray-500 text-sm">إجمالي الأرباح</p>
            <h3 class="text-2xl font-bold text-blue-600 mt-2">
                ${{ number_format($summary['total_earnings'] ?? 0,2) }}
            </h3>
        </div>



        <div class="bg-white rounded-2xl shadow p-5 border">
            <p class="text-gray-500 text-sm">أرباح اليوم</p>
            <h3 class="text-2xl font-bold text-purple-600 mt-2">
                ${{ number_format($summary['today_earnings'] ?? 0,2) }}
            </h3>
        </div>



        <div class="bg-white rounded-2xl shadow p-5 border">
            <p class="text-gray-500 text-sm">إجمالي النقرات</p>
            <h3 class="text-2xl font-bold text-gray-800 mt-2">
                {{ number_format($summary['total_clicks'] ?? 0) }}
            </h3>
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

                    <th class="p-4 text-right">
                        النوع
                    </th>

                    <th class="p-4 text-right">
                        المبلغ
                    </th>

                    <th class="p-4 text-right">
                        المرجع
                    </th>

                    <th class="p-4 text-right">
                        التأثير
                    </th>

                    <th class="p-4 text-right">
                        التاريخ
                    </th>

                </tr>

                </thead>



                <tbody>


                @forelse($transactions ?? [] as $entry)


                    @php

                    $isCredit =
                        strtoupper($entry->direction ?? '') === 'CREDIT'
                        ||
                        $entry->reference_type === 'click';

                    @endphp



                    <tr class="border-b hover:bg-gray-50">


                        <td class="p-4">

                            <span class="
                                px-3 py-1 rounded-full text-xs font-bold
                                {{ $isCredit
                                    ? 'bg-green-100 text-green-700'
                                    : 'bg-red-100 text-red-700'
                                }}
                            ">

                                {{ $isCredit ? 'ربح نقرة' : 'خصم' }}

                            </span>

                        </td>




                        <td class="p-4 font-bold
                            {{ $isCredit ? 'text-green-600' : 'text-red-600' }}">

                            {{ $isCredit ? '+' : '-' }}

                            ${{ number_format($entry->amount,6) }}

                        </td>




                        <td class="p-4">

                            <div class="font-medium">
                                {{ $entry->reference_type }}
                            </div>

                            <div class="text-xs text-gray-400">
                                #{{ $entry->reference_id }}
                            </div>

                        </td>




                        <td class="p-4">

                            <span class="
                            {{ $isCredit ? 'text-green-600' : 'text-red-600' }}
                            ">

                            {{ $isCredit
                                ? 'إضافة إلى الرصيد'
                                : 'خصم من الرصيد'
                            }}

                            </span>

                        </td>




                        <td class="p-4 text-gray-500">

                            {{ $entry->created_at?->format('Y/m/d') }}

                            <div class="text-xs">
                                {{ $entry->created_at?->format('H:i') }}
                            </div>

                        </td>


                    </tr>



                @empty


                    <tr>

                        <td colspan="5" class="p-12 text-center text-gray-500">

                            لا توجد عمليات مالية حتى الآن

                        </td>

                    </tr>


                @endforelse


                </tbody>


            </table>


        </div>




        @if(isset($transactions) && $transactions->count())

            <div class="p-5 border-t bg-gray-50">

                {{ $transactions->links() }}

            </div>

        @endif



    </div>


</div>


@endsection