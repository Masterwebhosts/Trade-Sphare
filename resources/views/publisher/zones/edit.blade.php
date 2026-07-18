@extends('layouts.app')

@section('content')

<div class="max-w-2xl mx-auto p-6 space-y-6">

    {{-- HEADER --}}
    <div>

        <h1 class="text-2xl font-bold">
            تعديل منطقة الإعلان
        </h1>

        <p class="text-gray-500 text-sm mt-1">
            تحديث بيانات المنطقة والإعلانات المرتبطة بها
        </p>
    </div>

    {{-- ERRORS --}}
    @if ($errors->any())

        <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-lg">

            <ul class="list-disc list-inside text-sm space-y-1">

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    {{-- FORM --}}
    <form method="POST"
          action="{{ route('publisher.zones.update', $zone->id) }}"
          class="bg-white border rounded-xl shadow-sm p-6 space-y-5">

        @csrf
        @method('PUT')

        {{-- NAME --}}
        <div>

            <label class="block text-sm font-medium mb-2">
                اسم المنطقة
            </label>

            <input type="text"
                   name="name"
                   value="{{ old('name',$zone->name) }}"
                   class="w-full border rounded-lg p-2"
                   required>

        </div>

        {{-- TYPE --}}
        <div>

            <label class="block text-sm font-medium mb-2">
                نوع المنطقة
            </label>

            <select name="zone_type"
                    class="w-full border rounded-lg p-2"
                    required>

                <option value="banner"
                    @selected(old('zone_type',$zone->zone_type)=='banner')>
                    Banner
                </option>

                <option value="native"
                    @selected(old('zone_type',$zone->zone_type)=='native')>
                    Native
                </option>

                <option value="popup"
                    @selected(old('zone_type',$zone->zone_type)=='popup')>
                    Popup
                </option>

            </select>

        </div>

        {{-- GOVERNORATE --}}
        <div>

            <label class="block text-sm font-medium mb-2">
                المحافظة
            </label>

            <select name="governorate_id"
                    class="w-full border rounded-lg p-2">

                <option value="">
                    كل سوريا
                </option>

                @foreach($governorates as $gov)

                    <option value="{{ $gov->id }}"
                        @selected(
                            old(
                                'governorate_id',
                                $zone->governorate_id
                            )
                            ==
                            $gov->id
                        )>

                        {{ $gov->name }}

                    </option>

                @endforeach

            </select>

        </div>






        {{-- ADS --}}
        <div>

            <label class="block text-sm font-medium mb-2">
                الإعلانات المسموح عرضها
            </label>


            <div class="border rounded-lg p-4 space-y-2 max-h-60 overflow-y-auto">


                @forelse($ads as $ad)


                    <label class="flex items-center gap-3">


                        <input
                            type="checkbox"
                            name="ads[]"
                            value="{{ $ad->id }}"
                            class="rounded"


                            @checked(
                                in_array(
                                    $ad->id,
                                    old(
                                        'ads',
                                        $zone->ads->pluck('id')->toArray()
                                    )
                                )
                            )

                        >


                        <span>

                            #{{ $ad->id }}
                            -
                            {{ $ad->title }}

                        </span>


                    </label>


                @empty


                    <p class="text-gray-500 text-sm">

                        لا توجد إعلانات نشطة متاحة

                    </p>


                @endforelse


            </div>


            <p class="text-xs text-gray-500 mt-2">

                إذا لم يتم اختيار إعلانات سيتم استخدام نظام التوزيع العام.

            </p>


        </div>







        {{-- ACTIONS --}}
        <div class="flex justify-end gap-3 pt-2">


            <a href="{{ route('publisher.zones.index') }}"
               class="px-4 py-2 rounded-lg border hover:bg-gray-50 text-sm">

                إلغاء

            </a>



            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg text-sm">

                حفظ التعديلات

            </button>

        </div>

    </form>

</div>

@endsection