@extends('layouts.app')

@section('content')

<div class="p-6 space-y-6" dir="rtl">

    <h1 class="text-2xl font-bold text-right">
        لوحة تحليل الاحتيال
    </h1>

    {{-- KPIs --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        <div class="p-4 bg-white border rounded text-right">
            <div class="text-gray-500">إجمالي النقرات</div>
            <div class="text-2xl font-bold">{{ $totalClicks }}</div>
        </div>

        <div class="p-4 bg-white border rounded text-right">
            <div class="text-gray-500">النقرات المشبوهة</div>
            <div class="text-2xl font-bold text-red-500">
                {{ $fraudClicks }}
            </div>
        </div>

        <div class="p-4 bg-white border rounded text-right">
            <div class="text-gray-500">نسبة الاحتيال</div>
            <div class="text-2xl font-bold">
                {{ $fraudRate }}%
            </div>
        </div>

    </div>

    {{-- Score Distribution --}}
    <div class="bg-white border p-4 rounded text-right">
        <h2 class="font-bold mb-2">توزيع درجة الاحتيال</h2>

        <ul class="space-y-1 text-sm">
            @foreach($scoreBuckets as $range => $count)
                <li>{{ $range }} → {{ $count }}</li>
            @endforeach
        </ul>
    </div>

    {{-- Top IPs --}}
    <div class="bg-white border p-4 rounded text-right">
        <h2 class="font-bold mb-2">أكثر عناوين IP نشاطًا (مشتبه بها)</h2>

        <ul class="text-sm space-y-1">
            @foreach($topIps as $ip)
                <li>{{ $ip->ip }} — {{ $ip->clicks }} نقرة</li>
            @endforeach
        </ul>
    </div>

    {{-- Top Ads --}}
    <div class="bg-white border p-4 rounded text-right">
        <h2 class="font-bold mb-2">أكثر الإعلانات نشاطًا مشبوهًا</h2>

        <ul class="text-sm space-y-1">
            @foreach($topAds as $ad)
                <li>
                    الإعلان #{{ $ad->ad_id }} — {{ $ad->clicks }} نقرة
                </li>
            @endforeach
        </ul>
    </div>

    {{-- Recent Fraud --}}
    <div class="bg-white border p-4 rounded text-right">
        <h2 class="font-bold mb-2">آخر الأنشطة المشبوهة</h2>

        <table class="w-full text-sm">
            <thead>
                <tr class="text-right border-b">
                    <th>ID</th>
                    <th>الإعلان</th>
                    <th>IP</th>
                    <th>درجة الاحتيال</th>
                    <th>التاريخ</th>
                </tr>
            </thead>

            <tbody>
                @foreach($recentFraud as $row)
                <tr class="border-b">
                    <td>{{ $row->id }}</td>
                    <td>{{ $row->ad_id }}</td>
                    <td>{{ $row->ip }}</td>

                    <td>
                        {{ $row->fraud_score ?? '0' }}
                    </td>

                    <td>{{ $row->created_at }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>

</div>

@endsection