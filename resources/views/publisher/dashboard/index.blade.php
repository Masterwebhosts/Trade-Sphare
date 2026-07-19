@extends('layouts.app')

@section('content')

@php
    $money = function ($value) {
    return number_format((float) ($value ?? 0), 4) . '$';
};
@endphp

<div class="max-w-7xl mx-auto p-6 space-y-6">

    {{-- HEADER --}}
    <div>
        <h1 class="text-2xl font-bold">لوحة تحكم الناشر</h1>
        <p class="text-gray-500 mt-1">نظرة شاملة على الأرباح والأداء الإعلاني</p>
    </div>

    {{-- KPI CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

        <div class="bg-white p-4 rounded-xl shadow">
            <div class="text-gray-500 text-sm">أرباح اليوم</div>
            <div class="text-2xl font-bold text-green-600">
                {{ $money($stats['today']['earnings'] ?? 0) }}
            </div>
        </div>

        <div class="bg-white p-4 rounded-xl shadow">
            <div class="text-gray-500 text-sm">أرباح الأمس</div>
            <div class="text-2xl font-bold">
                {{ $money($stats['yesterday']['earnings'] ?? 0) }}
            </div>
        </div>

        <div class="bg-white p-4 rounded-xl shadow">
            <div class="text-gray-500 text-sm">إجمالي الأرباح</div>
            <div class="text-2xl font-bold text-blue-600">
                {{ $money($stats['total']['earnings'] ?? 0) }}
            </div>
        </div>

        <div class="bg-white p-4 rounded-xl shadow">
            <div class="text-gray-500 text-sm">متوسط الربح لكل نقرة (EPC)</div>
            <div class="text-2xl font-bold">
                {{ $money($stats['epc'] ?? 0) }}
            </div>
        </div>

    </div>

    {{-- SECOND ROW --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        <div class="bg-white p-4 rounded-xl shadow">
            <div class="text-gray-500 text-sm">إجمالي النقرات</div>
            <div class="text-2xl font-bold">
                {{ number_format($stats['total']['clicks'] ?? 0) }}
            </div>
        </div>

        <div class="bg-white p-4 rounded-xl shadow">
            <div class="text-gray-500 text-sm">نقرات اليوم</div>
            <div class="text-2xl font-bold">
                {{ number_format($stats['today']['clicks'] ?? 0) }}
            </div>
        </div>

    </div>

    {{-- CHART --}}
    <div class="bg-white p-4 rounded-xl shadow">
        <h2 class="font-bold mb-4">الأرباح خلال آخر 7 أيام</h2>
        <canvas id="earningsChart" height="100"></canvas>
    </div>

    {{-- TOP ZONES + ADS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- ZONES --}}
        <div class="bg-white rounded-xl shadow p-4">
            <h2 class="font-bold mb-4">أفضل المناطق (Zones)</h2>

            <table class="w-full text-sm">
                <thead>
                    <tr class="text-right text-gray-500">
                        <th class="p-2 text-left">المنطقة</th>
                        <th class="p-2">النقرات</th>
                        <th class="p-2">الأرباح</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse(($stats['top_zones'] ?? []) as $zone)
                        <tr class="border-t">
                            <td class="p-2">
                                {{ $zone['name'] ?? ('Zone #' . ($zone['ad_zone_id'] ?? '-')) }}
                            </td>
                            <td class="p-2">
                                {{ $zone['clicks'] ?? 0 }}
                            </td>
                            <td class="p-2 text-green-600">
                                {{ $money($zone['earnings'] ?? 0) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="p-4 text-center text-gray-400">
                                لا توجد بيانات حالياً
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ADS --}}
        <div class="bg-white rounded-xl shadow p-4">
            <h2 class="font-bold mb-4">أفضل الإعلانات</h2>

            <table class="w-full text-sm">
                <thead>
                    <tr class="text-right text-gray-500">
                        <th class="p-2 text-left">الإعلان</th>
                        <th class="p-2">النقرات</th>
                        <th class="p-2">الأرباح</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse(($stats['top_ads'] ?? []) as $ad)
                        <tr class="border-t">
                            <td class="p-2">
                                {{ $ad['title'] ?? ('Ad #' . ($ad['ad_id'] ?? '-')) }}
                            </td>
                            <td class="p-2">
                                {{ $ad['clicks'] ?? 0 }}
                            </td>
                            <td class="p-2 text-blue-600">
                                {{ $money($ad['earnings'] ?? 0) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="p-4 text-center text-gray-400">
                                لا توجد بيانات حالياً
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

</div>

{{-- Chart --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
@if(Route::has('publisher.analytics.chart'))
fetch("{{ route('publisher.analytics.chart') }}")
    .then(res => res.json())
    .then(data => {

        const ctx = document.getElementById('earningsChart').getContext('2d');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: data.labels || [],
                datasets: [
                    {
                        label: 'الأرباح',
                        data: data.earnings || [],
                        borderWidth: 2
                    },
                    {
                        label: 'النقرات',
                        data: data.clicks || [],
                        borderWidth: 2
                    }
                ]
            }
        });

    })
    .catch(() => {
        console.warn('فشل تحميل بيانات الرسم البياني');
    });
@endif
</script>

@endsection