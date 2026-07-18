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

            مراجعة الإعلان

        </h1>



        <a href="{{ route('admin.ads.index') }}"
           class="text-blue-600 text-sm hover:underline">

            ← رجوع

        </a>


    </div>




    <div class="bg-white p-6 rounded-xl shadow-sm border space-y-5">



        <div>

            <div class="text-gray-500 text-sm">
                معرف الإعلان
            </div>


            <div class="font-semibold">
                #{{ $ad->id }}
            </div>

        </div>




        <div>

            <div class="text-gray-500 text-sm">
                عنوان الإعلان
            </div>


            <div class="font-semibold">
                {{ $ad->title ?: 'بدون عنوان' }}
            </div>

        </div>




        <div>

            <div class="text-gray-500 text-sm">
                الحملة
            </div>


            <div class="font-semibold">

                {{ $ad->campaign?->title ?? 'بدون حملة' }}

            </div>

        </div>




        <div>

            <div class="text-gray-500 text-sm">
                نوع المحتوى
            </div>


            <div class="font-semibold">

                {{ $ad->content_type }}

            </div>

        </div>




        <div>

            <div class="text-gray-500 text-sm">
                الحالة الحالية
            </div>


            <span class="{{ $statusColors[$status] ?? 'text-gray-500' }} font-medium">

                {{ $statusLabels[$status] ?? $status }}

            </span>

        </div>




        <div class="pt-4 flex gap-3">


            <form method="POST"
                  action="{{ route('admin.ads.approve', $ad->id) }}">

                @csrf


                <button type="submit"
                        class="bg-green-600 text-white px-5 py-2 rounded-lg hover:bg-green-700">

                    قبول الإعلان

                </button>


            </form>




            <form method="POST"
                  action="{{ route('admin.ads.reject', $ad->id) }}">

                @csrf


                <button type="submit"
                        class="bg-red-600 text-white px-5 py-2 rounded-lg hover:bg-red-700">

                    رفض الإعلان

                </button>


            </form>



        </div>



    </div>


</div>


@endsection