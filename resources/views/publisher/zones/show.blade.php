@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto p-6 space-y-6">


    {{-- HEADER --}}
    <div>

        <h1 class="text-2xl font-bold">
            تفاصيل منطقة الإعلان
        </h1>

        <p class="text-gray-500 text-sm mt-1">
            معلومات المنطقة وروابط التضمين والإعلانات المرتبطة
        </p>

    </div>



    {{-- INFO CARD --}}
    <div class="bg-white border rounded-xl shadow-sm p-6 space-y-6">


        {{-- BASIC INFO --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 text-sm">


            <div>
                <div class="text-gray-500">
                    معرف المنطقة
                </div>

                <div class="font-semibold">
                    {{ $zone->id }}
                </div>
            </div>



            <div>
                <div class="text-gray-500">
                    اسم المنطقة
                </div>

                <div class="font-semibold">
                    {{ $zone->name }}
                </div>
            </div>



            <div>
                <div class="text-gray-500">
                    نوع المنطقة
                </div>

                <div class="font-semibold">
                    {{ ucfirst($zone->zone_type) }}
                </div>
            </div>



            <div>
                <div class="text-gray-500">
                    المحافظة
                </div>

                <div class="font-semibold">

                    {{ 
                        $zone->governorate
                        ? $zone->governorate->name
                        : 'كل سوريا'
                    }}

                </div>

            </div>



            <div>
                <div class="text-gray-500">
                    الحالة
                </div>

                <div class="font-semibold text-green-600">
                    {{ $zone->status }}
                </div>
            </div>



        </div>



        {{-- API URL --}}
        <div>


            <label class="block text-sm font-semibold mb-2">
                رابط تشغيل الإعلان
            </label>


            @php

                $apiUrl = url(
                    '/api/zones/'.$zone->token.'/serve'
                );

            @endphp


            <div class="flex gap-2">

                <input
                    id="apiUrl"
                    readonly
                    value="{{ $apiUrl }}"
                    class="w-full border rounded-lg p-2 text-sm bg-gray-50"
                >


                <button
                    onclick="copyText('apiUrl')"
                    class="bg-blue-600 text-white px-4 rounded-lg text-sm">

                    نسخ

                </button>

            </div>


        </div>




        {{-- EMBED SCRIPT --}}
        <div>


            <label class="block text-sm font-semibold mb-2">
                كود التضمين
            </label>


            @php

                $script =
                "<script src='".url('/js/serve.js')."' data-zone='".$zone->token."'></script>";

            @endphp



            <div class="flex gap-2">


                <input
                    id="embedCode"
                    readonly
                    value="{{ $script }}"
                    class="w-full border rounded-lg p-2 text-xs bg-gray-50"
                >


                <button
                    onclick="copyText('embedCode')"
                    class="bg-green-600 text-white px-4 rounded-lg text-sm">

                    نسخ

                </button>


            </div>


        </div>





        {{-- EMBED URL --}}
        <div>


            <label class="block text-sm font-semibold mb-2">
                رابط التضمين المباشر
            </label>


            @php

                $embedUrl = url(
                    '/embed/zones/'.$zone->token
                );

            @endphp



            <div class="flex gap-2">


                <input
                    id="embedUrl"
                    readonly
                    value="{{ $embedUrl }}"
                    class="w-full border rounded-lg p-2 text-sm bg-gray-50"
                >


                <button
                    onclick="copyText('embedUrl')"
                    class="bg-gray-700 text-white px-4 rounded-lg text-sm">

                    نسخ

                </button>


            </div>


        </div>





        {{-- ADS --}}
        <div>


            <label class="block text-sm font-semibold mb-2">
                الإعلانات المرتبطة
            </label>


            <div class="border rounded-lg p-4 space-y-2">


                @forelse($zone->ads as $ad)


                    <div class="text-sm">

                        #{{ $ad->id }}
                        -
                        {{ $ad->title }}

                    </div>


                @empty


                    <div class="text-gray-500 text-sm">

                        لا يوجد إعلانات مربوطة،
                        سيتم استخدام التوزيع العام.

                    </div>


                @endforelse


            </div>


        </div>




    </div>


</div>





<div id="toast"
     class="fixed bottom-5 left-1/2 -translate-x-1/2 bg-gray-900 text-white px-4 py-2 rounded-lg hidden text-sm">

تم النسخ ✔

</div>




<script>

function copyText(id)
{

    const input = document.getElementById(id);

    navigator.clipboard.writeText(input.value);


    const toast =
        document.getElementById('toast');


    toast.classList.remove('hidden');


    setTimeout(()=>{

        toast.classList.add('hidden');

    },1500);

}

</script>


@endsection