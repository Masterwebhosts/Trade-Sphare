@extends('layouts.app')

@section('content')

<div class="p-6 space-y-6">


    {{-- HEADER --}}
    <div class="flex justify-between items-center">

        <h1 class="text-2xl font-bold">
            مراجعة الحملة
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



        $status = $campaign->status ?? Campaign::STATUS_PENDING;



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




    {{-- CAMPAIGN INFO --}}
    <div class="bg-white p-6 rounded shadow space-y-4">


        <div>
            ID:
            <span class="font-semibold">
                {{ $campaign->id }}
            </span>
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

            <p class="text-gray-600 mt-1">

                {{ $campaign->description ?: 'لا يوجد وصف' }}

            </p>

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

            CPC:

            ${{ number_format((float) $campaign->cpc, 2) }}

        </div>



        <div>

            فترة الحملة:

            {{ $campaign->start_date?->format('Y-m-d') }}

            -

            {{ $campaign->end_date?->format('Y-m-d') }}

        </div>



    </div>





    {{-- ACTIONS --}}
    <div class="bg-white p-6 rounded shadow">


        <div class="flex gap-3">



            {{-- APPROVE --}}
            <form method="POST"
                  action="{{ route('admin.campaigns.approve', $campaign->id) }}">

                @csrf


                <button type="submit"
                        class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">

                    موافقة

                </button>


            </form>





            {{-- REJECT --}}
            <form method="POST"
                  action="{{ route('admin.campaigns.reject', $campaign->id) }}">

                @csrf


                <button type="submit"
                        class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">

                    رفض

                </button>


            </form>





            {{-- DELETE --}}
            <form method="POST"
                  action="{{ route('admin.campaigns.destroy', $campaign->id) }}"
                  onsubmit="return confirm('هل أنت متأكد من حذف الحملة؟')">


                @csrf

                @method('DELETE')


                <button type="submit"
                        class="bg-gray-700 text-white px-4 py-2 rounded hover:bg-gray-800">

                    حذف

                </button>


            </form>


        </div>


    </div>


</div>


@endsection