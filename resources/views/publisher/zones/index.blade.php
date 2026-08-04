@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto p-6 space-y-6">


    {{-- HEADER --}}
    <div class="flex justify-between items-center">

        <h1 class="text-2xl font-bold">
            مناطق الإعلانات
        </h1>

        <a href="{{ route('publisher.zones.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm">
            + إضافة منطقة جديدة
        </a>

    </div>



    {{-- EMPTY STATE --}}
    @if($zones->isEmpty())

        <div class="bg-white border rounded-xl p-10 text-center text-gray-500">

            لا توجد مناطق إعلانية حتى الآن

            <div class="mt-3">
                <a href="{{ route('publisher.zones.create') }}"
                   class="text-blue-600 hover:underline">
                    إنشاء أول منطقة
                </a>
            </div>

        </div>


    @else


        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">


            @foreach($zones as $zone)


                <div class="bg-white border rounded-xl shadow-sm p-5 space-y-4">


                    {{-- TITLE --}}
                    <div>

                        <h2 class="text-lg font-bold">
                            {{ $zone->name }}
                        </h2>


                        <p class="text-xs text-gray-500">
                            معرف المنطقة: {{ $zone->id }}
                        </p>


                        <div class="flex gap-2 mt-2">


                            <span class="text-xs px-2 py-1 rounded bg-gray-100">

                                {{ ucfirst($zone->zone_type) }}

                            </span>


                            <span class="text-xs px-2 py-1 rounded 
                                {{ $zone->status === 'active'
                                    ? 'bg-green-100 text-green-700'
                                    : 'bg-red-100 text-red-700' }}">

                                {{ $zone->status }}

                            </span>


                        </div>

                    </div>




                    {{-- INFO --}}

                    <div class="text-sm text-gray-600 space-y-1">

                        <div>
                            الناشر:
                            {{ auth()->user()->name }}
                        </div>


                        <div>
                            تاريخ الإنشاء:
                            {{ $zone->created_at->format('Y-m-d') }}
                        </div>


                    </div>




                    {{-- EMBED SCRIPT --}}

                   @php

    $script = "<script src='" .
        asset('js/serve.js') .
        "?v=" . filemtime(public_path('js/serve.js')) .
        "' data-zone='" .
        $zone->token .
        "' data-base='" .
        url('/') .
        "'></script>";

@endphp

                    <div class="bg-gray-50 p-3 rounded-lg space-y-2">


                        <div class="text-sm font-semibold">
                            كود التضمين
                        </div>


                        <input
                            id="embed{{ $zone->id }}"
                            value="{{ $script }}"
                            readonly
                            class="w-full text-xs border rounded p-2 bg-white"
                        >


                        <button
                            onclick="copyText('embed{{ $zone->id }}')"
                            class="bg-green-600 hover:bg-green-700 text-white text-xs px-3 py-1 rounded">

                            نسخ الكود

                        </button>


                    </div>




                    {{-- EMBED URL --}}

                    <div class="bg-gray-50 p-3 rounded-lg space-y-2">


                        <div class="text-sm font-semibold">
                            رابط التضمين
                        </div>


                        <input

                            id="link{{ $zone->id }}"

                            value="{{ $zone->embed_url }}"

                            readonly

                            class="w-full text-xs border rounded p-2 bg-white"

                        >


                        <button

                            onclick="copyText('link{{ $zone->id }}')"

                            class="bg-blue-600 hover:bg-blue-700 text-white text-xs px-3 py-1 rounded">

                            نسخ الرابط

                        </button>


                    </div>




                    {{-- ACTIONS --}}

                    <div class="flex gap-4 text-sm pt-2">


                        <a href="{{ route('publisher.zones.analytics',$zone->id) }}"
                           class="text-green-600 hover:underline">

                            التحليلات

                        </a>



                        <a href="{{ route('publisher.zones.edit',$zone->id) }}"
                           class="text-blue-600 hover:underline">

                            تعديل

                        </a>



                        <form action="{{ route('publisher.zones.destroy',$zone->id) }}"
                              method="POST"
                              onsubmit="return confirm('هل أنت متأكد من حذف هذه المنطقة؟')">


                            @csrf
                            @method('DELETE')


                            <button class="text-red-600 hover:underline">

                                حذف

                            </button>


                        </form>


                    </div>



                </div>


            @endforeach


        </div>


    @endif


</div>




<div id="toast"
     class="fixed bottom-5 left-1/2 -translate-x-1/2 bg-gray-900 text-white px-4 py-2 rounded-lg hidden shadow-lg text-sm">

    تم النسخ ✔

</div>



<script>

function copyText(id){

    const el=document.getElementById(id);

    const toast=document.getElementById('toast');

    if(!el) return;


    navigator.clipboard.writeText(el.value);


    toast.classList.remove('hidden');


    setTimeout(()=>{

        toast.classList.add('hidden');

    },1500);

}

</script>


@endsection