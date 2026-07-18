@extends('layouts.app')

@section('content')

<div class="p-6 space-y-6">

    <h1 class="text-2xl font-bold">
        لوحة التحكم الإدارية
    </h1>

    {{-- KPI GRID --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

        {{-- USERS --}}
        <div class="bg-white p-4 rounded shadow">
            <div class="text-gray-500 text-sm">المستخدمون</div>
            <div class="text-xl font-semibold">{{ $users }}</div>
        </div>

        <div class="bg-white p-4 rounded shadow">
            <div class="text-gray-500 text-sm">الناشرون</div>
            <div class="text-xl font-semibold">{{ $publishers }}</div>
        </div>

        <div class="bg-white p-4 rounded shadow">
            <div class="text-gray-500 text-sm">المعلنون</div>
            <div class="text-xl font-semibold">{{ $advertisers }}</div>
        </div>

        {{-- CAMPAIGNS / ADS --}}
        <div class="bg-white p-4 rounded shadow">
            <div class="text-gray-500 text-sm">الحملات الإعلانية</div>
            <div class="text-xl font-semibold">{{ $campaigns }}</div>
        </div>

        <div class="bg-white p-4 rounded shadow">
            <div class="text-gray-500 text-sm">الإعلانات</div>
            <div class="text-xl font-semibold">{{ $ads }}</div>
        </div>

        {{-- CLICKS --}}
        <div class="bg-white p-4 rounded shadow">
            <div class="text-gray-500 text-sm">النقرات (إجمالي)</div>
            <div class="text-xl font-semibold">{{ $clicks }}</div>
        </div>

        <div class="bg-white p-4 rounded shadow">
            <div class="text-gray-500 text-sm">النقرات الصالحة</div>
            <div class="text-xl font-semibold text-green-600">
                {{ $validClicks ?? 0 }}
            </div>
        </div>

        <div class="bg-white p-4 rounded shadow">
            <div class="text-gray-500 text-sm">النقرات المشبوهة</div>
            <div class="text-xl font-semibold text-red-600">
                {{ $fraudClicks ?? 0 }}
            </div>
        </div>

        {{-- FRAUD LAYER --}}
        <div class="bg-white p-4 rounded shadow">
            <div class="text-gray-500 text-sm">
                النقرات المشبوهة (Fraud Layer)
            </div>

            <div class="text-xl font-semibold text-orange-600">
                {{ $suspicious_clicks ?? 0 }}
            </div>
        </div>

        <div class="bg-white p-4 rounded shadow">
            <div class="text-gray-500 text-sm">
                معدل الاحتيال
            </div>

            <div class="text-xl font-semibold text-red-500">
                {{ number_format($fraud_rate ?? 0, 2) }}%
            </div>
        </div>

        <div class="bg-white p-4 rounded shadow">
            <div class="text-gray-500 text-sm">
                متوسط درجة الاحتيال
            </div>

            <div class="text-xl font-semibold text-yellow-600">
                {{ number_format($average_fraud_score ?? 0, 2) }}
            </div>
        </div>

        {{-- IMPRESSIONS --}}
        <div class="bg-white p-4 rounded shadow">
            <div class="text-gray-500 text-sm">مرات الظهور</div>
            <div class="text-xl font-semibold">{{ $impressions }}</div>
        </div>

        {{-- CTR --}}
        <div class="bg-white p-4 rounded shadow">
            <div class="text-gray-500 text-sm">نسبة النقر (CTR)</div>
            <div class="text-xl font-semibold">
                {{ number_format($ctr, 2) }}%
            </div>
        </div>

        {{-- TRAFFIC QUALITY --}}
        <div class="bg-white p-4 rounded shadow">
            <div class="text-gray-500 text-sm">جودة الترافيك</div>

            <div class="text-xl font-semibold">
                @php
                    $quality = ($clicks > 0)
                        ? round(($validClicks / $clicks) * 100, 2)
                        : 0;
                @endphp

                {{ $quality }}%
            </div>
        </div>

        {{-- FRAUD RATE FROM LEDGER --}}
        <div class="bg-white p-4 rounded shadow">
            <div class="text-gray-500 text-sm">معدل التلاعب</div>

            <div class="text-xl font-semibold text-red-500">
                @php
                    $fraudRateLedger = ($clicks > 0)
                        ? round(($fraudClicks / $clicks) * 100, 2)
                        : 0;
                @endphp

                {{ $fraudRateLedger }}%
            </div>
        </div>

    </div>

    {{-- SUMMARY --}}
    <div class="bg-white p-4 rounded shadow">

        <h2 class="font-bold mb-2">
            نظرة عامة على النظام
        </h2>

        <p class="text-gray-600 text-sm leading-relaxed">
            تعرض هذه اللوحة إحصائيات مباشرة للنظام مع فصل النقرات الصالحة
            عن النقرات المشبوهة. يعتمد النظام على Ledger-based accounting
            مع طبقة متقدمة لمكافحة الاحتيال وتحليل جودة الترافيك.
        </p>

    </div>

</div>

@endsection