@extends('layouts.app')

@section('content')

@php
    function money($value): string {
    return number_format((float) $value, 6) . '$';
}
@endphp

<div class="max-w-7xl mx-auto p-6 space-y-6">

    {{-- HEADER --}}
    <div>
        <h1 class="text-2xl font-bold">الأرباح</h1>
        <p class="text-gray-500 mt-1">سجل جميع الأرباح المحققة من الإعلانات</p>
    </div>

    {{-- TOTAL --}}
    <div class="bg-white border rounded-2xl p-5 shadow-sm">
        <div class="text-sm text-gray-500">إجمالي الأرباح</div>
        <div class="text-3xl font-bold text-green-600 mt-1">
            ${{ number_format($total ?? 0, 6) }}
        </div>
    </div>

    {{-- TABLE --}}
    <div class="bg-white border rounded-2xl shadow-sm overflow-hidden">

        <div class="p-4 border-b bg-gray-50">
            <h2 class="font-semibold text-gray-700">تفاصيل الأرباح</h2>
        </div>

        <table class="w-full text-sm">

            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="p-3 text-left">المبلغ</th>
                    <th class="p-3 text-left">الإعلان</th>
                    <th class="p-3 text-left">النوع</th>
                    <th class="p-3 text-left">التاريخ</th>
                </tr>
            </thead>

            <tbody>

                @forelse($earnings as $e)

                    @php
                        $meta = [];

                        if (!empty($e->meta)) {
                            $meta = is_array($e->meta)
                                ? $e->meta
                                : json_decode($e->meta, true);
                        }
                    @endphp

                    <tr class="border-t hover:bg-gray-50 transition">

                        <td class="p-3 font-semibold text-green-600">
                            ${{ number_format($e->amount, 6) }}
                        </td>

                        <td class="p-3 text-gray-700">
                            Ad #{{ $meta['ad_id'] ?? $e->ad_id ?? 'غير معروف' }}
                        </td>

                        <td class="p-3 text-gray-500">
                            {{ $e->type ?? 'earning' }}
                        </td>

                        <td class="p-3 text-gray-500">
                            {{ optional($e->created_at)->format('Y-m-d H:i') }}
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="4" class="p-8 text-center text-gray-400">
                            لا توجد أرباح مسجلة حالياً
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    {{-- PAGINATION --}}
    @if(method_exists($earnings, 'links'))
        <div class="mt-4">
            {{ $earnings->links() }}
        </div>
    @endif

</div>

@endsection