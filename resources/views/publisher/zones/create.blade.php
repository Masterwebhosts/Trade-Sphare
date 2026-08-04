@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto p-6">

    {{-- HEADER --}}
    <div class="mb-6">

        <h1 class="text-2xl font-bold text-gray-800">
            إنشاء منطقة إعلان جديدة
        </h1>

        <p class="text-gray-500 mt-1">
            اختر المحافظة وسيتم عرض الإعلانات المتاحة لهذه المنطقة فقط.
        </p>

    </div>


    {{-- ERRORS --}}
    @if ($errors->any())

        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">

            <ul class="list-disc list-inside text-red-600 text-sm">

                @foreach ($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif



    {{-- FORM --}}

    <form method="POST"
          action="{{ route('publisher.zones.store') }}"
          class="bg-white border rounded-xl shadow p-6 space-y-6">

        @csrf



        {{-- NAME --}}

        <div>

            <label class="block font-medium mb-2">
                اسم المنطقة
            </label>


            <input
                type="text"
                name="name"
                value="{{ old('name') }}"
                placeholder="مثال: الصفحة الرئيسية"
                class="w-full border rounded-lg p-3"
                required>

        </div>




        {{-- TYPE --}}

        <div>

            <label class="block font-medium mb-2">
                نوع المنطقة
            </label>


            <select
                name="zone_type"
                class="w-full border rounded-lg p-3"
                required>


                <option value="banner">
                    Banner
                </option>


                <option value="native">
                    Native
                </option>


                <option value="popup">
                    Popup
                </option>


            </select>

        </div>




        {{-- GOVERNORATE --}}

        <div>

            <label class="block font-medium mb-2">
                المحافظة
            </label>


            <select
                id="governorate"
                name="governorate_id"
                class="w-full border rounded-lg p-3">


                <option value="">
                    كل سوريا
                </option>



                @foreach($governorates as $gov)

                    <option
                        value="{{ $gov->id }}"
                        @selected(old('governorate_id') == $gov->id)>

                        {{ $gov->name }}

                    </option>


                @endforeach


            </select>


            <p class="text-xs text-gray-500 mt-2">

                عند اختيار محافظة سيتم جلب إعلاناتها فقط.

            </p>


        </div>
                {{-- ADS LIST --}}

        <div>

            <label class="block font-medium mb-3">
                الإعلانات المسموح عرضها
            </label>



            <div
                id="adsContainer"
                class="border rounded-lg max-h-80 overflow-y-auto divide-y">


                <div class="p-4 text-center text-gray-500 text-sm">

                    اختر المحافظة لعرض الإعلانات المتاحة

                </div>


            </div>



            <p class="text-xs text-gray-500 mt-3">

                إذا لم يتم اختيار إعلانات محددة، سيستخدم النظام التوزيع العام.

            </p>


        </div>




        {{-- ACTION --}}

        <div class="flex justify-end">


            <button
                type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg">


                حفظ المنطقة


            </button>


        </div>



    </form>


</div>
<script>

const governorateSelect =
    document.getElementById('governorate');


const adsContainer =
    document.getElementById('adsContainer');



function loadAds(governorateId = '') {


    adsContainer.innerHTML = `

        <div class="p-4 text-center text-gray-500 text-sm">
            جاري تحميل الإعلانات...
        </div>

    `;



    fetch(
        `/publisher/ads-by-governorate?governorate_id=${governorateId}`
    )

    .then(response => response.json())


    .then(ads => {


        if (!ads.length) {


            adsContainer.innerHTML = `

                <div class="p-4 text-center text-gray-500 text-sm">

                    لا توجد إعلانات متاحة لهذه المحافظة.

                </div>

            `;


            return;

        }




        adsContainer.innerHTML = '';



        ads.forEach(ad => {


            const campaign =
                ad.campaign
                ? ad.campaign.title
                : '';



            const governorate =
                ad.campaign &&
                ad.campaign.governorate_id
                ? 'مخصص للمحافظة'
                : 'كل سوريا';



            adsContainer.innerHTML += `


                <label class="flex items-center justify-between p-3 hover:bg-gray-50 border-b">


                    <div>


                        <div class="font-medium">

                            #${ad.id}
                            -
                            ${ad.title}

                        </div>


                        <div class="text-xs text-gray-500">

                            حملة:
                            ${campaign}

                            -

                            ${governorate}

                        </div>


                    </div>



                    <input

                        type="checkbox"

                        name="ads[]"

                        value="${ad.id}"

                        class="rounded"

                    >



                </label>


            `;


        });



    })


    .catch(error => {


        console.error(error);



        adsContainer.innerHTML = `

            <div class="p-4 text-center text-red-500 text-sm">

                حدث خطأ أثناء تحميل الإعلانات.

            </div>

        `;


    });


}




governorateSelect.addEventListener(
    'change',
    function(){


        loadAds(
            this.value
        );


    }
);




// تحميل أولي
loadAds(
    governorateSelect.value
);



</script>


@endsection