@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto p-6 space-y-6">


    {{-- HEADER --}}
    <div>

        <h1 class="text-2xl font-bold">
            تحليلات منطقة الإعلان
        </h1>

        <p class="text-gray-500 text-sm mt-1">
            أداء المنطقة والإعلانات المعروضة فيها
        </p>

    </div>



    {{-- ZONE INFO --}}
    <div class="bg-white border rounded-xl shadow-sm p-6">


        <div class="grid grid-cols-1 md:grid-cols-4 gap-5 text-sm">


            <div>

                <div class="text-gray-500">
                    اسم المنطقة
                </div>

                <div class="font-bold">
                    {{ $zone->name }}
                </div>

            </div>



            <div>

                <div class="text-gray-500">
                    النوع
                </div>

                <div class="font-bold">
                    {{ ucfirst($zone->zone_type) }}
                </div>

            </div>




            <div>

                <div class="text-gray-500">
                    المحافظة
                </div>

                <div class="font-bold">

                    {{
                        $zone->governorate
                        ? $zone->governorate->name
                        : 'كل سوريا'
                    }}

                </div>

            </div>




            <div>

                <div class="text-gray-500">
                    الإعلانات المرتبطة
                </div>

                <div class="font-bold">

                    {{ $zone->ads_count ?? $zone->ads->count() }}

                </div>

            </div>


        </div>


    </div>





    {{-- PERFORMANCE --}}
    <div class="bg-white border rounded-xl shadow-sm p-6">


        @php

            $impressions =
                $analytics['impressions'] ?? 0;

            $clicks =
                $analytics['clicks'] ?? 0;


            $ctr =
                $impressions > 0
                ? ($clicks / $impressions) * 100
                : 0;


            $revenue =
                $analytics['revenue'] ?? 0;


            $cpc =
                $clicks > 0
                ? $revenue / $clicks
                : 0;


        @endphp





        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">


            <div class="bg-gray-50 rounded-lg p-4">

                <div class="text-xs text-gray-500">
                    مرات الظهور
                </div>

                <div class="text-xl font-bold">
                    {{ number_format($impressions) }}
                </div>

            </div>




            <div class="bg-gray-50 rounded-lg p-4">

                <div class="text-xs text-gray-500">
                    النقرات
                </div>

                <div class="text-xl font-bold">
                    {{ number_format($clicks) }}
                </div>

            </div>





            <div class="bg-gray-50 rounded-lg p-4">


                <div class="text-xs text-gray-500">
                    CTR
                </div>


                <div class="text-xl font-bold">
                    {{ number_format($ctr,2) }}%
                </div>


            </div>





            <div class="bg-gray-50 rounded-lg p-4">


                <div class="text-xs text-gray-500">
                    الأرباح
                </div>


                <div class="text-xl font-bold text-green-600">

                    ${{ number_format($revenue,6) }}

                </div>


            </div>



        </div>



    </div>







    {{-- LINK --}}
    <div class="bg-white border rounded-xl shadow-sm p-6">


        <h3 class="font-bold mb-3">
            روابط المنطقة
        </h3>



        <div class="space-y-3">


            <input
                readonly
                value="{{ url('/embed/zones/'.$zone->token) }}"
                class="w-full border rounded-lg p-2 text-sm bg-gray-50"
            >



            <input
                readonly
                value="<script src='{{ url('/js/serve.js') }}' data-zone='{{ $zone->token }}'></script>"
                class="w-full border rounded-lg p-2 text-xs bg-gray-50"
            >


        </div>


    </div>

</div>


@endsection