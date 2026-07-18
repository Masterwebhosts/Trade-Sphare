@extends('layouts.app')

@section('content')

<div class="p-6 space-y-6">


    {{-- HEADER --}}
    <div class="flex justify-between items-center">

        <h1 class="text-2xl font-bold">
            تفاصيل الحملة
        </h1>


        <a href="{{ route('admin.campaigns.index') }}"
           class="text-blue-600 hover:underline">

            ← رجوع

        </a>

    </div>



    @php

        $budget = (float) ($campaign->budget_total ?? 0);

        $spent = (float) ($campaign->budget_spent ?? 0);

        $remaining = (float) ($campaign->budget_remaining ?? 0);


        $usage = $budget > 0
            ? round(($spent / $budget) * 100)
            : 0;



        $status = $campaign->status ?? 'pending';



        $class = match($status) {


            'approved',
            'active'
                => 'bg-green-100 text-green-700',


            'pending'
                => 'bg-yellow-100 text-yellow-700',


            'rejected'
                => 'bg-red-100 text-red-700',


            'paused'
                => 'bg-orange-100 text-orange-700',


            'completed'
                => 'bg-blue-100 text-blue-700',


            default
                => 'bg-gray-100 text-gray-700',

        };


    @endphp




    {{-- DETAILS --}}

    <div class="bg-white p-6 rounded shadow space-y-4">


        <div class="font-medium">

            ID:
            {{ $campaign->id }}

        </div>



        <div>

            اسم الحملة:

            <span class="font-semibold">

                {{ $campaign->title ?: 'بدون عنوان' }}

            </span>

        </div>



        <div>

            الحالة:

            <span class="px-2 py-1 text-xs rounded {{ $class }}">

                {{ $status }}

            </span>

        </div>



        <div>

            الوصف:

            <div class="mt-1 text-gray-600">

                {{ $campaign->description ?: 'لا يوجد وصف' }}

            </div>

        </div>



        <div>

            الميزانية:

            <span class="font-semibold">

                ${{ number_format($budget, 2) }}

            </span>

        </div>



        <div class="text-red-600">

            المصروف:

            ${{ number_format($spent, 2) }}

        </div>



        <div class="text-green-600">

            المتبقي:

            ${{ number_format($remaining, 2) }}

        </div>



        <div>

            نسبة الاستهلاك:

            {{ $usage }}%

        </div>



        <div>

            تكلفة النقرة CPC:

            ${{ number_format((float) $campaign->cpc, 2) }}

        </div>



        <div>

            تاريخ البداية:

            {{ $campaign->start_date?->format('Y-m-d') }}

        </div>



        <div>

            تاريخ النهاية:

            {{ $campaign->end_date?->format('Y-m-d') }}

        </div>



        <div>

            تاريخ الإنشاء:

            {{ $campaign->created_at?->format('Y-m-d H:i') }}

        </div>


    </div>


</div>


@endsection