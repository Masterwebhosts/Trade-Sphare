@extends('layouts.app')

@section('content')

<div class="p-6 space-y-6">


    @php

        $status = $ad->status ?? 'pending_review';



        $statusLabels = [

            'pending_review' => 'بانتظار المراجعة',

            'active' => 'نشط',

            'rejected' => 'مرفوض',

            'paused' => 'متوقف',

            'deleted' => 'محذوف',

        ];



        $statusColors = [

            'pending_review' => 'text-yellow-600',

            'active' => 'text-green-600',

            'rejected' => 'text-red-600',

            'paused' => 'text-gray-500',

            'deleted' => 'text-gray-400',

        ];

    @endphp




    <div class="flex justify-between items-center">


        <h1 class="text-2xl font-bold text-gray-900">

            تفاصيل الإعلان

        </h1>



        <a href="{{ route('admin.ads.index') }}"
           class="text-blue-600 text-sm hover:underline">

            ← رجوع

        </a>


    </div>





    <div class="bg-white p-6 rounded-xl shadow-sm border space-y-4">



        <div>

            <span class="text-gray-500">
                المعرف:
            </span>


            <div class="font-medium">

                #{{ $ad->id }}

            </div>

        </div>




        <div>

            <span class="text-gray-500">
                العنوان:
            </span>


            <div class="font-medium">

                {{ $ad->title ?: 'بدون عنوان' }}

            </div>

        </div>




        <div>

            <span class="text-gray-500">
                الحملة:
            </span>


            <div class="font-medium">

                {{ $ad->campaign?->title ?? 'بدون حملة' }}

            </div>

        </div>




        <div>

            <span class="text-gray-500">
                الوصف:
            </span>


            <div class="font-medium">

                {{ $ad->description ?: 'لا يوجد وصف' }}

            </div>

        </div>




        <div>

            <span class="text-gray-500">
                نوع المحتوى:
            </span>


            <div class="font-medium">

                {{ $ad->content_type }}

            </div>

        </div>




        <div>

            <span class="text-gray-500">
                الحالة:
            </span>


            <div>

                <span class="{{ $statusColors[$status] ?? 'text-gray-500' }} font-medium">

                    {{ $statusLabels[$status] ?? $status }}

                </span>

            </div>


        </div>




        <div>

            <span class="text-gray-500">
                رابط الهدف:
            </span>


            <div class="font-medium break-all">

                {{ $ad->target_url }}

            </div>


        </div>




        <div>

            <span class="text-gray-500">
                رابط الوسائط:
            </span>


            <div class="font-medium break-all">

                {{ $ad->media_url }}

            </div>


        </div>




        <div>

            <span class="text-gray-500">
                تاريخ الإنشاء:
            </span>


            <div class="font-medium">

                {{ $ad->created_at?->format('Y-m-d H:i') }}

            </div>


        </div>



    </div>


</div>


@endsection