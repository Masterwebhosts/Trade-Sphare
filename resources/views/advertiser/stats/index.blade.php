@extends('layouts.app')

@section('content')


<div class="max-w-7xl mx-auto space-y-6">

    {{-- HEADER --}}
    <div>
        <h1 class="text-2xl font-bold">
            لوحة الإحصائيات
        </h1>

        <p class="text-gray-500 mt-1">
            عرض شامل لأداء الحملات الإعلانية
        </p>
    </div>

    {{-- GLOBAL STATS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        <div class="bg-white rounded-xl shadow p-5 border">
            <div class="text-sm text-gray-500">
                عدد مرات الظهور
            </div>
            <div class="text-3xl font-bold mt-2">
                {{ number_format($impressions) }}
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-5 border">
            <div class="text-sm text-gray-500">
                عدد النقرات
            </div>
            <div class="text-3xl font-bold mt-2">
                {{ number_format($clicks) }}
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-5 border">
            <div class="text-sm text-gray-500">
                معدل النقر (CTR)
            </div>
            <div class="text-3xl font-bold mt-2 text-blue-600">
                {{ number_format($ctr, 2) }}%
            </div>
        </div>

    </div>

    {{-- TABLE --}}
    <div class="bg-white rounded-xl shadow overflow-hidden border">

        <div class="p-4 border-b">
            <h2 class="text-lg font-semibold">
                أداء الحملات
            </h2>
        </div>

        @if($campaignStats->isEmpty())

            <div class="p-8 text-center text-gray-500">
                لا توجد بيانات إحصائية متاحة
            </div>

        @else

            <div class="overflow-x-auto">

                <table class="w-full text-sm">

                    <thead class="bg-gray-50 text-gray-600">

                        <tr>

                            <th class="text-right p-4">
                                الحملة
                            </th>

                            <th class="text-right p-4">
                                الظهور
                            </th>

                            <th class="text-right p-4">
                                النقرات
                            </th>

                            <th class="text-right p-4">
                                CTR
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($campaignStats as $stat)

                            @php
                                $ctrValue = $stat['ctr'] ?? 0;

                                $ctrClass = match(true) {
                                    $ctrValue >= 5 => 'bg-green-100 text-green-700',
                                    $ctrValue >= 2 => 'bg-yellow-100 text-yellow-700',
                                    default => 'bg-red-100 text-red-700',
                                };
                            @endphp

                            <tr class="border-t hover:bg-gray-50">

                                <td class="p-4 font-medium">
                                    {{ $stat['name'] }}
                                </td>

                                <td class="p-4">
                                    {{ number_format($stat['impressions']) }}
                                </td>

                                <td class="p-4">
                                    {{ number_format($stat['clicks']) }}
                                </td>

                                <td class="p-4">

                                    <span class="px-2 py-1 rounded text-xs {{ $ctrClass }}">
                                        {{ number_format($ctrValue, 2) }}%
                                    </span>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @endif

    </div>

</div>

@endsection
