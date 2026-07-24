@extends('layouts.app')

@section('content')

@php
    $money = function ($value) {

        $value = (float) ($value ?? 0);

        if (fmod($value * 100, 1) != 0) {
            return '$' . number_format($value, 3);
        }

        return '$' . number_format($value, 2);
    };

    $getEarnings = function ($data) {
        return $data['earnings']
            ?? $data['revenue']
            ?? $data['amount']
            ?? $data['profit']
            ?? 0;
    };
@endphp

<div class="max-w-7xl mx-auto p-6 space-y-4">

    <div>
        <h1 class="text-2xl font-bold">لوحة تحكم الناشر</h1>
        <p class="text-gray-500">
            نظرة شاملة على الأرباح والأداء الإعلاني
        </p>
    </div>


    {{-- الأرباح --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

        <div class="bg-white p-4 rounded-xl shadow">
            <div class="text-gray-500 text-sm">
                أرباح اليوم
            </div>

            <div class="text-2xl font-bold text-green-600">
                {{ $money($getEarnings($stats['today'] ?? [])) }}
            </div>
        </div>


        <div class="bg-white p-4 rounded-xl shadow">
            <div class="text-gray-500 text-sm">
                أرباح الأمس
            </div>

            <div class="text-2xl font-bold">
                {{ $money($getEarnings($stats['yesterday'] ?? [])) }}
            </div>
        </div>


        <div class="bg-white p-4 rounded-xl shadow">
            <div class="text-gray-500 text-sm">
                إجمالي الأرباح
            </div>

            <div class="text-2xl font-bold text-blue-600">
                {{ $money($getEarnings($stats['total'] ?? [])) }}
            </div>
        </div>


        <div class="bg-white p-4 rounded-xl shadow">
            <div class="text-gray-500 text-sm">
                متوسط الربح لكل نقرة EPC
            </div>

            <div class="text-2xl font-bold">
                {{ $money(
                    ($stats['total']['clicks'] ?? 0) > 0
                    ? $getEarnings($stats['total']) / $stats['total']['clicks']
                    : 0
                ) }}
            </div>
        </div>

    </div>



    {{-- النقرات --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        <div class="bg-white p-4 rounded-xl shadow">
            <div class="text-gray-500 text-sm">
                إجمالي النقرات
            </div>

            <div class="text-2xl font-bold">
                {{ number_format($stats['total']['clicks'] ?? 0) }}
            </div>
        </div>


        <div class="bg-white p-4 rounded-xl shadow">
            <div class="text-gray-500 text-sm">
                نقرات اليوم
            </div>

            <div class="text-2xl font-bold">
                {{ number_format($stats['today']['clicks'] ?? 0) }}
            </div>
        </div>

    </div>



    {{-- الرسم --}}
    <div class="bg-white p-4 rounded-xl shadow">

        <h2 class="font-bold mb-4">
            الأرباح خلال آخر 7 أيام
        </h2>

        <canvas id="earningsChart"></canvas>

    </div>




    {{-- المناطق والإعلانات --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">


        <div class="bg-white rounded-xl shadow p-4">

            <h2 class="font-bold mb-4">
                أفضل المناطق
            </h2>

            <table class="w-full text-sm">

                <thead>
                <tr class="text-gray-500">
                    <th class="p-2 text-left">المنطقة</th>
                    <th class="p-2">النقرات</th>
                    <th class="p-2">الأرباح</th>
                </tr>
                </thead>


                <tbody>

                @forelse($stats['top_zones'] ?? [] as $zone)

                    <tr class="border-t">

                        <td class="p-2">
                            {{ $zone['name'] ?? ('Zone #'.($zone['ad_zone_id'] ?? '-')) }}
                        </td>

                        <td class="p-2">
                            {{ $zone['clicks'] ?? 0 }}
                        </td>


                        <td class="p-2 text-green-600">
                            {{ $money($getEarnings($zone)) }}
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="3" class="p-4 text-center text-gray-400">
                            لا توجد بيانات
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>



        <div class="bg-white rounded-xl shadow p-4">

            <h2 class="font-bold mb-4">
                أفضل الإعلانات
            </h2>


            <table class="w-full text-sm">

                <thead>

                <tr class="text-gray-500">

                    <th class="p-2 text-left">
                        الإعلان
                    </th>

                    <th class="p-2">
                        النقرات
                    </th>

                    <th class="p-2">
                        الأرباح
                    </th>

                </tr>

                </thead>


                <tbody>

                @forelse($stats['top_ads'] ?? [] as $ad)

                    <tr class="border-t">

                        <td class="p-2">
                            {{ $ad['title'] ?? ('Ad #'.($ad['ad_id'] ?? '-')) }}
                        </td>


                        <td class="p-2">
                            {{ $ad['clicks'] ?? 0 }}
                        </td>


                        <td class="p-2 text-blue-600">
                            {{ $money($getEarnings($ad)) }}
                        </td>


                    </tr>


                @empty

                    <tr>
                        <td colspan="3" class="p-4 text-center text-gray-400">
                            لا توجد بيانات
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>


        </div>


    </div>


</div>



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script>

@if(Route::has('publisher.analytics.chart'))

fetch("{{ route('publisher.analytics.chart') }}?t={{ time() }}")

.then(response => response.json())

.then(data => {

new Chart(
document.getElementById('earningsChart'),
{
type:'line',

data:{

labels:data.labels ?? [],

datasets:[

{
label:'الأرباح',
data:data.earnings ?? [],
borderWidth:2
},

{
label:'النقرات',
data:data.clicks ?? [],
borderWidth:2
}

]

}

}

);


});


@endif

</script>


@endsection