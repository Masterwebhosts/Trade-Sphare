@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto">


    <div class="flex justify-between items-center mb-6">

        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                إنشاء حملة إعلانية
            </h1>

            <p class="text-gray-500 text-sm mt-1">
                أنشئ حملة جديدة وحدد الميزانية والاستهداف
            </p>
        </div>


        <a href="{{ route('advertiser.campaigns.index') }}"
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
          action="{{ route('advertiser.campaigns.store') }}"
          class="bg-white shadow rounded-xl p-6 space-y-6">

        @csrf





        {{-- اسم الحملة --}}

        <div>

            <label for="name"
                   class="block mb-2 font-medium text-gray-700">

                عنوان الحملة

            </label>


            <input
                id="name"
                type="text"
                name="name"
                value="{{ old('name') }}"
                class="w-full border rounded-lg p-3 focus:ring focus:ring-blue-200"
                placeholder="مثال: حملة الصيف الترويجية"
                required>

        </div>

       {{-- الميزانية --}}

        <div>

            <label for="budget_total"
                   class="block mb-2 font-medium text-gray-700">

                الميزانية الإجمالية ($)

            </label>


            <input
                id="budget_total"
                type="number"
                name="budget_total"
                step="0.01"
                min="0.01"
                value="{{ old('budget_total') }}"
                class="w-full border rounded-lg p-3 focus:ring focus:ring-blue-200"
                required>


            <p class="text-sm text-gray-500 mt-1">

                المبلغ الإجمالي المخصص للحملة.

            </p>

        </div>







        {{-- المحافظة --}}

        <div>

            <label for="governorate_id"
                   class="block mb-2 font-medium text-gray-700">

                المحافظة

            </label>


            <select
                id="governorate_id"
                name="governorate_id"
                class="w-full border rounded-lg p-3 focus:ring focus:ring-blue-200">


                <option value="">
                    جميع المحافظات
                </option>



                @foreach($governorates as $gov)

                    <option value="{{ $gov->id }}"
                        @selected(old('governorate_id') == $gov->id)>

                        {{ $gov->name }}

                    </option>


                @endforeach


            </select>


            <p class="text-sm text-gray-500 mt-1">

                اتركها فارغة لاستهداف جميع المناطق.

            </p>


        </div>
{{-- CPC --}}

<div>

    <label class="block mb-2 font-medium text-gray-700">

        سعر النقرة

    </label>


    <div class="w-full border rounded-lg p-3 bg-gray-50">

        10 سنت

    </div>


    <p class="text-sm text-gray-500 mt-1">

        سعر النقرة ثابت لجميع الحملات.

    </p>

</div>
        {{-- التواريخ --}}

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">


            <div>

                <label for="start_date"
                       class="block mb-2 font-medium text-gray-700">

                    تاريخ البداية

                </label>


                <input
                    id="start_date"
                    type="date"
                    name="start_date"
                    value="{{ old('start_date') }}"
                    class="w-full border rounded-lg p-3"
                    required>

            </div>




            <div>

                <label for="end_date"
                       class="block mb-2 font-medium text-gray-700">

                    تاريخ النهاية

                </label>


                <input
                    id="end_date"
                    type="date"
                    name="end_date"
                    value="{{ old('end_date') }}"
                    class="w-full border rounded-lg p-3"
                    required>

            </div>


        </div>







        <button
            type="submit"
            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 rounded-lg">

            إنشاء الحملة

        </button>



    </form>


</div>

@endsection