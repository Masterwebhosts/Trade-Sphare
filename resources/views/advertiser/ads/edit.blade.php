@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto">


    <div class="flex items-center justify-between mb-6">

        <div>

            <h1 class="text-2xl font-bold text-gray-800">
                تعديل الإعلان
            </h1>


            <p class="text-gray-500 text-sm mt-1">
                تحديث بيانات الإعلان المرتبط بالحملة
            </p>

        </div>


        <a href="{{ route('advertiser.ads.index') }}"
           class="px-4 py-2 border rounded-lg hover:bg-gray-50 text-sm">

            رجوع

        </a>


    </div>




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
          action="{{ route('advertiser.ads.update', $ad->id) }}"
          class="bg-white shadow rounded-xl p-6 space-y-6">

        @csrf

        @method('PUT')




        {{-- الحملة --}}

        <div>

            <label class="block mb-2 font-medium text-gray-700">
                الحملة الإعلانية
            </label>


            <select name="campaign_id"
                    class="w-full border rounded-lg p-3"
                    required>


                @foreach($campaigns as $campaign)

                    <option value="{{ $campaign->id }}"
                        @selected(old('campaign_id', $ad->campaign_id) == $campaign->id)>

                        {{ $campaign->title }}

                    </option>


                @endforeach


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
                    @selected(old('content_type', $ad->content_type) == 'banner')>

                    بانر

                </option>


                <option value="video"
                    @selected(old('content_type', $ad->content_type) == 'video')>

                    فيديو

                </option>


                <option value="text"
                    @selected(old('content_type', $ad->content_type) == 'text')>

                    نصي

                </option>


            </select>


        </div>






        {{-- العنوان --}}

        <div>

            <label class="block mb-2 font-medium text-gray-700">
                عنوان الإعلان
            </label>


            <input type="text"
                   name="title"
                   value="{{ old('title', $ad->title) }}"
                   class="w-full border rounded-lg p-3"
                   required>


        </div>






        {{-- الوصف --}}

        <div>

            <label class="block mb-2 font-medium text-gray-700">
                وصف الإعلان
            </label>


            <textarea name="description"
                      rows="4"
                      class="w-full border rounded-lg p-3">{{ old('description', $ad->description) }}</textarea>


        </div>






        {{-- رابط الوسائط --}}

        <div>

            <label class="block mb-2 font-medium text-gray-700">
                رابط الوسائط
            </label>


            <input type="url"
                   name="media_url"
                   value="{{ old('media_url', $ad->media_url) }}"
                   class="w-full border rounded-lg p-3">


        </div>






        {{-- رابط الهدف --}}

        <div>

            <label class="block mb-2 font-medium text-gray-700">
                رابط الهدف
            </label>


            <input type="url"
                   name="target_url"
                   value="{{ old('target_url', $ad->target_url) }}"
                   class="w-full border rounded-lg p-3"
                   required>


        </div>






        <div class="flex gap-3 pt-4">


            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg">

                حفظ التعديلات

            </button>



            <a href="{{ route('advertiser.ads.index') }}"
               class="px-6 py-3 border rounded-lg hover:bg-gray-50">

                إلغاء

            </a>


        </div>



    </form>


</div>


@endsection