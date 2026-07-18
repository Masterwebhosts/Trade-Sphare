@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto space-y-6">

    {{-- HEADER --}}
    <div class="flex items-center justify-between">

        <h1 class="text-2xl font-bold">
            لوحة تحكم المعلن
        </h1>

        <div class="flex gap-2">

            <a href="{{ route('advertiser.campaigns.create') }}"
               class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                إنشاء حملة
            </a>

            <a href="{{ route('advertiser.ads.create') }}"
               class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                إنشاء إعلان
            </a>

        </div>

    </div>

    {{-- KPI CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

        <div class="bg-white rounded-xl shadow p-5">
            <div class="text-sm text-gray-500">عدد الحملات</div>
            <div class="text-3xl font-bold mt-2">
                {{ $stats['campaigns'] ?? 0 }}
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-5">
            <div class="text-sm text-gray-500">عدد الإعلانات</div>
            <div class="text-3xl font-bold mt-2">
                {{ $stats['ads'] ?? 0 }}
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-5">
            <div class="text-sm text-gray-500">النقرات</div>
            <div class="text-3xl font-bold mt-2">
                {{ $stats['clicks'] ?? 0 }}
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-5">
            <div class="text-sm text-gray-500">الإنفاق</div>
            <div class="text-3xl font-bold mt-2 text-red-600">
                ${{ number_format($stats['total_spent'] ?? 0, 2) }}
            </div>
        </div>

    </div>

    {{-- CAMPAIGNS --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">

        <div class="p-4 border-b">
            <h2 class="font-semibold">آخر الحملات</h2>
        </div>

        @if($campaigns->count() == 0)

            <div class="p-6 text-center text-gray-500">
                لا توجد حملات حالياً
            </div>

        @else

            <div class="overflow-x-auto">

                <table class="w-full text-sm">

                    <thead class="bg-gray-50 text-gray-600">
                        <tr>
                            <th class="text-right p-4">اسم الحملة</th>
                            <th class="text-right p-4">الميزانية</th>
                            <th class="text-right p-4">الحالة</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($campaigns as $campaign)

                            <tr class="border-t hover:bg-gray-50">

                                <td class="p-4 font-medium">
                                    {{ $campaign->name }}
                                </td>

                                <td class="p-4">
                                    ${{ number_format($campaign->budget_total, 2) }}
                                </td>

                                <td class="p-4">

                                    @if($campaign->status === 'active')
                                        <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded">
                                            نشطة
                                        </span>
                                    @elseif($campaign->status === 'paused')
                                        <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-700 rounded">
                                            متوقفة
                                        </span>
                                    @else
                                        <span class="px-2 py-1 text-xs bg-gray-100 text-gray-700 rounded">
                                            {{ ucfirst($campaign->status) }}
                                        </span>
                                    @endif

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @endif

    </div>

    {{-- ADS --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">

        <div class="p-4 border-b">
            <h2 class="font-semibold">آخر الإعلانات</h2>
        </div>

        @if($ads->count() == 0)

            <div class="p-6 text-center text-gray-500">
                لا توجد إعلانات حالياً
            </div>

        @else

            <div class="overflow-x-auto">

                <table class="w-full text-sm">

                    <thead class="bg-gray-50 text-gray-600">
                        <tr>
                            <th class="text-right p-4">العنوان</th>
                            <th class="text-right p-4">الحملة</th>
                            <th class="text-right p-4">الحالة</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($ads as $ad)

                            <tr class="border-t hover:bg-gray-50">

                                <td class="p-4">
                                    {{ $ad->title }}
                                </td>

                                <td class="p-4">
                                    {{ $ad->campaign?->name ?? '-' }}
                                </td>

                                <td class="p-4">

                                    @if($ad->status === 'active')
                                        <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded">
                                            نشط
                                        </span>
                                    @elseif($ad->status === 'pending_review')
                                        <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-700 rounded">
                                            قيد المراجعة
                                        </span>
                                    @else
                                        <span class="px-2 py-1 text-xs bg-gray-100 text-gray-700 rounded">
                                            {{ ucfirst($ad->status) }}
                                        </span>
                                    @endif

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