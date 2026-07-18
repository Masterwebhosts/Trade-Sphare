@extends('layouts.app')

@section('content')

@php
    $clicks = $clicks ?? 0;
    $impressions = $impressions ?? 0;
    $ctr = $ctr ?? 0;
@endphp

<div class="p-6 space-y-6">

    <h1 class="text-2xl font-bold">لوحة التحليلات</h1>

    {{-- مؤشرات رئيسية --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4">

        <div class="bg-white p-4 rounded shadow">
            <div class="text-gray-500 text-sm">المستخدمين</div>
            <div class="text-xl font-semibold">{{ $users ?? 0 }}</div>
        </div>

        <div class="bg-white p-4 rounded shadow">
            <div class="text-gray-500 text-sm">الحملات</div>
            <div class="text-xl font-semibold">{{ $campaigns ?? 0 }}</div>
        </div>

        <div class="bg-white p-4 rounded shadow">
            <div class="text-gray-500 text-sm">الإعلانات</div>
            <div class="text-xl font-semibold">{{ $ads ?? 0 }}</div>
        </div>

        <div class="bg-white p-4 rounded shadow">
            <div class="text-gray-500 text-sm">النقرات</div>
            <div class="text-xl font-semibold">{{ $clicks }}</div>
        </div>

        <div class="bg-white p-4 rounded shadow">
            <div class="text-gray-500 text-sm">مرات الظهور</div>
            <div class="text-xl font-semibold">{{ $impressions }}</div>
        </div>

        <div class="bg-white p-4 rounded shadow">
            <div class="text-gray-500 text-sm">معدل النقر (CTR)</div>
            <div class="text-xl font-semibold">
                {{ number_format($ctr, 2) }}%
            </div>
        </div>

    </div>

    {{-- مؤشرات إضافية --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        <div class="bg-white p-5 rounded shadow">
            <div class="text-sm text-gray-500">نسبة التفاعل</div>
            <div class="text-xl font-bold mt-2">
                {{ $impressions > 0 ? round(($clicks / $impressions) * 100, 2) : 0 }}%
            </div>
        </div>

        <div class="bg-white p-5 rounded shadow">
            <div class="text-sm text-gray-500">حالة النظام</div>
            <div class="text-xl font-bold mt-2 text-green-600">
                يعمل بشكل طبيعي
            </div>
        </div>

    </div>

</div>

@endsection
