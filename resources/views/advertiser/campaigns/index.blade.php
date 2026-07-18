@extends('layouts.app')

@section('content')

<div class="flex justify-between items-center mb-6">

    <h1 class="text-2xl font-bold">
        الحملات الإعلانية
    </h1>

    <a href="{{ route('advertiser.campaigns.create') }}"
       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm">
        + حملة جديدة
    </a>

</div>

@if(session('success'))
    <div class="bg-green-100 text-green-700 p-3 mb-4 rounded">
        {{ session('success') }}
    </div>
@endif


<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

@forelse($campaigns as $c)

    @php
        $budget = (float) $c->budget_total;
        $spent  = (float) $c->budget_spent;
        $remaining = max(0, $budget - $spent);

        $statusColors = [
            'approved' => 'bg-green-100 text-green-700',
            'Pending'  => 'bg-yellow-100 text-yellow-700',
            'rejected' => 'bg-red-100 text-red-700',
        ];
    @endphp

    <div class="bg-white p-4 rounded-xl shadow border">

        {{-- HEADER --}}
        <div class="flex justify-between items-start">

            <h2 class="font-bold text-lg">
                {{ $c->title }}
            </h2>

          @php
    $statusText = [
        'approved' => 'مقبولة',
        'pending'  => 'قيد الانتظار',
        'rejected' => 'مرفوضة',
    ];

    $statusColors = [
        'approved' => 'bg-green-100 text-green-700',
        'pending'  => 'bg-yellow-100 text-yellow-700',
        'rejected' => 'bg-red-100 text-red-700',
    ];

    $status = strtolower(trim($c->status));
@endphp

<span class="px-2 py-1 text-xs rounded {{ $statusColors[$c->status] ?? 'bg-gray-200 text-gray-700' }}">
   {{ $statusText[strtolower(trim($c->status))] ?? $c->status }}
</span>

        </div>

        {{-- INFO --}}
        <div class="text-sm text-gray-600 mt-3 space-y-1">

            <div>
                الميزانية:
                <b>${{ number_format($budget, 2) }}</b>
            </div>

            <div>
                المصروف:
                <b class="text-red-600">${{ number_format($spent, 2) }}</b>
            </div>

            <div>
                المتبقي:
                <b class="{{ $remaining > 0 ? 'text-green-600' : 'text-red-600' }}">
                    ${{ number_format($remaining, 2) }}
                </b>
            </div>

            <div>
                قيمة النقرة:
                <b>${{ number_format($c->cpc ?? 0, 2) }}</b>
            </div>

        </div>

        {{-- ACTIONS --}}
        <div class="mt-4 flex gap-2">

            <a href="{{ route('advertiser.campaigns.edit', $c->id) }}"
               class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                تعديل
            </a>

            <form action="{{ route('advertiser.campaigns.destroy', $c->id) }}"
                  method="POST"
                  onsubmit="return confirm('هل أنت متأكد من حذف الحملة؟');">

                @csrf
                @method('DELETE')

                <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                    حذف
                </button>

            </form>

        </div>

    </div>

@empty

    <div class="col-span-full text-center text-gray-500 p-6">
        لا توجد حملات إعلانية حالياً
    </div>

@endforelse

</div>

@endsection