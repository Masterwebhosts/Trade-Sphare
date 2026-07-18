@extends('layouts.app')

@section('content')

<div class="max-w-2xl mx-auto">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">

        <h1 class="text-2xl font-bold text-gray-800">
            تعديل الحملة الإعلانية
        </h1>

        <a href="{{ route('advertiser.campaigns.index') }}"
           class="px-4 py-2 border rounded-lg hover:bg-gray-50 text-sm">
            رجوع
        </a>

    </div>

    {{-- ERRORS --}}
    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 p-4 mb-6 rounded-lg">

            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>
    @endif

    {{-- FORM --}}
    <form action="{{ route('advertiser.campaigns.update', $campaign->id) }}"
          method="POST"
          class="bg-white p-6 rounded-xl shadow space-y-5">

        @csrf
        @method('PUT')

        {{-- NAME --}}
        <div>
            <label class="block mb-2 font-medium text-gray-700">
                اسم الحملة
            </label>

            <input type="text"
                   name="title"
                   value="{{ old('title', $campaign->title) }}"
                   class="w-full border rounded-lg p-3"
                   required>
        </div>

        {{-- TOTAL BUDGET --}}
        <div>
            <label class="block mb-2 font-medium text-gray-700">
                الميزانية الإجمالية ($)
            </label>

            <input type="number"
                   step="0.01"
                   name="budget_total"
                   value="{{ old('budget_total', $campaign->budget_total) }}"
                   class="w-full border rounded-lg p-3"
                   required>
        </div>

        {{-- CPC --}}
        <div>
            <label class="block mb-2 font-medium text-gray-700">
                سعر النقرة (CPC $)
            </label>

            <input type="number"
                   step="0.01"
                   name="cpc"
                   value="{{ old('cpc', $campaign->cpc ?? 0) }}"
                   class="w-full border rounded-lg p-3"
                   required>
        </div>

        {{-- DAILY BUDGET --}}
        <div>
            <label class="block mb-2 font-medium text-gray-700">
                الميزانية اليومية (اختياري)
            </label>

            <input type="number"
                   step="0.01"
                   name="daily_budget"
                   value="{{ old('daily_budget', $campaign->daily_budget ?? null) }}"
                   class="w-full border rounded-lg p-3">
        </div>

        {{-- CITY / GOVERNORATE --}}
<div>
    <label class="block mb-2 font-medium text-gray-700">
        المدينة
    </label>

    <select name="governorate_id"
            class="w-full border rounded-lg p-3"
            required>

        <option value="">-- اختر المدينة --</option>

        @foreach(\App\Models\Governorate::orderBy('name')->get() as $gov)
            <option value="{{ $gov->id }}"
                {{ old('governorate_id', $campaign->governorate_id) == $gov->id ? 'selected' : '' }}>
                {{ $gov->name }}
            </option>
        @endforeach

    </select>
</div>

        {{-- DATES --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div>
                <label class="block mb-2 font-medium text-gray-700">
                    تاريخ البدء
                </label>

                <input type="date"
                       name="start_date"
                       value="{{ old('start_date', $campaign->start_date) }}"
                       class="w-full border rounded-lg p-3">
            </div>

            <div>
                <label class="block mb-2 font-medium text-gray-700">
                    تاريخ الانتهاء
                </label>

                <input type="date"
                       name="end_date"
                       value="{{ old('end_date', $campaign->end_date) }}"
                       class="w-full border rounded-lg p-3">
            </div>

        </div>

        {{-- ACTIONS --}}
        <div class="flex gap-3 pt-4">

            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">

                حفظ التعديلات

            </button>

            <a href="{{ route('advertiser.campaigns.index') }}"
               class="bg-gray-100 hover:bg-gray-200 px-5 py-2 rounded-lg">

                إلغاء

            </a>

        </div>

    </form>

</div>

@endsection