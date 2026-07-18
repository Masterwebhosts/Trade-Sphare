@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto">


    {{-- HEADER --}}

    <div class="flex items-center justify-between mb-6">


        <div>

            <h1 class="text-2xl font-bold text-gray-800">

                إنشاء إعلان جديد

            </h1>


            <p class="text-gray-500 text-sm mt-1">

                اربط الإعلان بحملة موجودة وأنشئ المادة الإعلانية

            </p>


        </div>




        <a href="{{ route('advertiser.ads.index') }}"
           class="px-4 py-2 border rounded-lg hover:bg-gray-50 text-sm">

            رجوع

        </a>


    </div>







    {{-- الرصيد --}}

    @if($balance <= 0)

        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700">


            رصيد المحفظة غير كافٍ.
            

            <a href="{{ url('advertiser/wallet/topup') }}"
               class="underline font-medium">

                تعبئة الرصيد

            </a>


        </div>


    @endif







    {{-- ERRORS --}}

    @if ($errors->any())

        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">


            <ul class="list-disc list-inside text-red-600 text-sm">


                @foreach ($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach


            </ul>


        </div>


    @endif







    <form method="POST"
          action="{{ route('advertiser.ads.store') }}"
          class="bg-white shadow rounded-xl p-6 space-y-6">


        @csrf






        {{-- اختيار الحملة --}}

        <div>


            <label class="block mb-2 font-medium text-gray-700">

                الحملة الإعلانية

            </label>




            <select name="campaign_id"
                    class="w-full border rounded-lg p-3"
                    required>


                <option value="">

                    اختر الحملة

                </option>



                @forelse($campaigns as $campaign)


                    <option value="{{ $campaign->id }}"
                        @selected(old('campaign_id') == $campaign->id)>


                        {{ $campaign->title }}


                    </option>


                @empty


                    <option disabled>

                        لا توجد حملات، قم بإنشاء حملة أولاً

                    </option>


                @endforelse



            </select>



        </div>








        {{-- نوع الإعلان --}}


        <div>


            <label class="block mb-2 font-medium text-gray-700">

                نوع الإعلان

            </label>




            <select name="content_type"
                    class="w-full border rounded-lg p-3"
                    required>


                <option value="banner"
                    @selected(old('content_type') == 'banner')>

                    بانر

                </option>



                <option value="video"
                    @selected(old('content_type') == 'video')>

                    فيديو

                </option>



                <option value="text"
                    @selected(old('content_type') == 'text')>

                    نصي

                </option>



            </select>



        </div>









        {{-- العنوان --}}


        <div>


            <label class="block mb-2 font-medium text-gray-700">

                عنوان الإعلان

            </label>




            <input
                type="text"
                name="title"
                value="{{ old('title') }}"
                class="w-full border rounded-lg p-3"
                placeholder="مثال: خصومات الصيف"
                required>



        </div>









        {{-- الوصف --}}


        <div>


            <label class="block mb-2 font-medium text-gray-700">

                وصف الإعلان

            </label>



            <textarea
                name="description"
                rows="4"
                class="w-full border rounded-lg p-3"
                placeholder="اكتب وصف الإعلان...">{{ old('description') }}</textarea>



        </div>









        {{-- الصورة أو الفيديو --}}


        <div>


            <label class="block mb-2 font-medium text-gray-700">

                رابط الوسائط

            </label>




            <input
                type="url"
                name="media_url"
                value="{{ old('media_url') }}"
                class="w-full border rounded-lg p-3"
                placeholder="https://example.com/image.jpg">



            <p class="text-sm text-gray-500 mt-1">

                اختياري: رابط صورة أو فيديو الإعلان.

            </p>



        </div>









        {{-- رابط الهدف --}}


        <div>


            <label class="block mb-2 font-medium text-gray-700">

                رابط الهدف

            </label>




            <input
                type="url"
                name="target_url"
                value="{{ old('target_url') }}"
                class="w-full border rounded-lg p-3"
                placeholder="https://example.com"
                required>



            <p class="text-sm text-gray-500 mt-1">

                الرابط الذي ينتقل إليه المستخدم عند الضغط.

            </p>



        </div>









        <button
            type="submit"
            class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-medium">


            إنشاء الإعلان


        </button>





    </form>


</div>

@endsection