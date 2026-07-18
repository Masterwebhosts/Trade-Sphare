@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto">

    {{-- HEADER --}}
    <div class="flex justify-between items-start mb-6">

        <div>
            <h1 class="text-2xl font-bold">الإعلانات</h1>
            <p class="text-gray-500">إدارة الإعلانات والحملات الإعلانية</p>
        </div>

        <a href="{{ route('advertiser.ads.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
            + إنشاء إعلان
        </a>

    </div>

    {{-- SUCCESS --}}
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 p-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    {{-- EMPTY STATE --}}
    @if($ads->isEmpty())

        <div class="bg-white rounded-xl shadow p-10 text-center">

            <h2 class="text-lg font-semibold mb-2">لا توجد إعلانات حالياً</h2>

            <p class="text-gray-500 mb-4">
                قم بإنشاء أول إعلان لبدء عرض حملاتك.
            </p>

            <a href="{{ route('advertiser.ads.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded-lg">
                إنشاء إعلان
            </a>

        </div>

    @else

        @php
            $statusLabels = [
    'pending_review' => 'قيد المراجعة',
    'pending' => 'قيد الانتظار',
    'active' => 'نشط',
    'rejected' => 'مرفوض',
    'paused' => 'متوقف',
    'deleted' => 'محذوف',
];

$statusColors = [
    'pending_review' => 'bg-yellow-100 text-yellow-700',
    'pending' => 'bg-yellow-100 text-yellow-700',
    'active' => 'bg-green-100 text-green-700',
    'rejected' => 'bg-red-100 text-red-700',
    'paused' => 'bg-gray-100 text-gray-700',
    'deleted' => 'bg-gray-200 text-gray-600',
];
        @endphp

        <div class="bg-white rounded-xl shadow overflow-hidden">

            <div class="overflow-x-auto">

                <table class="w-full text-sm">

                    <thead class="bg-gray-50">
                        <tr>
                            <th class="p-4 text-left">ID</th>
                            <th class="p-4 text-left">العنوان</th>
                            <th class="p-4 text-left">الحملة</th>
                            <th class="p-4 text-left">التنسيق</th>
                            <th class="p-4 text-left">النوع</th>
                            <th class="p-4 text-left">الحالة</th>
                            <th class="p-4 text-left">الظهور</th>
                            <th class="p-4 text-left">النقرات</th>
                            <th class="p-4 text-left">CTR</th>
                            <th class="p-4 text-left">الإجراءات</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($ads as $ad)

                            @php
    $impressions = $ad->impressions_count ?? 0;
    $clicks = $ad->clicks_count ?? 0;

    $ctr = $impressions > 0
        ? round(($clicks / $impressions) * 100, 2)
        : 0;

    $status = strtolower(trim($ad->status ?? 'pending'));
@endphp

                            <tr class="border-t hover:bg-gray-50">

                                <td class="p-4">{{ $ad->id }}</td>

                                <td class="p-4 font-medium">{{ $ad->title }}</td>

                                <td class="p-4 text-gray-600">{{ $ad->campaign?->name ?? '-' }}</td>

                                <td class="p-4">{{ $ad->format?->name ?? '-' }}</td>

                                <td class="p-4">{{ ucfirst($ad->type ?? '-') }}</td>

                                {{-- STATUS --}}
                                <td class="p-4">
                                    <span class="px-2 py-1 text-xs rounded {{ $statusColors[$status] ?? 'bg-gray-100 text-gray-700' }}">
                                        {{ $statusLabels[$status] ?? $status }}
                                    </span>
                                </td>

                                <td class="p-4">{{ number_format($impressions) }}</td>

                                <td class="p-4">{{ number_format($clicks) }}</td>

                                <td class="p-4">
                                    <span class="{{ $ctr >= 5 ? 'text-green-600' : ($ctr >= 2 ? 'text-yellow-600' : 'text-red-600') }}">
                                        {{ $ctr }}%
                                    </span>
                                </td>

                                <td class="p-4">

                                    <div class="flex gap-3">

                                        <a href="{{ route('advertiser.ads.edit', $ad->id) }}"
                                           class="text-blue-600 hover:underline">
                                            تعديل
                                        </a>

                                        <form method="POST"
                                              action="{{ route('advertiser.ads.destroy', $ad->id) }}"
                                              onsubmit="return confirm('هل تريد حذف الإعلان؟')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="text-red-600 hover:underline">
                                                حذف
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

        <div class="mt-6">
            {{ $ads->links() }}
        </div>

    @endif

</div>

@endsection