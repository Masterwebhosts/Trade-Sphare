@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto">

    {{-- TITLE --}}
    <h2 class="text-2xl font-bold mb-6">
        شحن المحفظة
    </h2>

    {{-- BALANCE --}}
    <div class="bg-white shadow rounded-xl p-5 mb-6 border">

        <div class="text-sm text-gray-500">
            الرصيد الحالي
        </div>

        <div class="text-3xl font-bold text-green-600 mt-1">
            ${{ number_format($balance, 2) }}
        </div>

    </div>

    {{-- SUCCESS --}}
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 text-green-700 border border-green-200 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    {{-- ERRORS --}}
    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-50 text-red-700 border border-red-200 rounded-lg">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FORM --}}
    <form method="POST"
          action="{{ route('advertiser.topup.store') }}"
          enctype="multipart/form-data"
          class="bg-white shadow rounded-xl p-6 space-y-5 border">

        @csrf

        {{-- AMOUNT --}}
        <div>
            <label class="block mb-2 font-medium">
                مبلغ الشحن (الحد الأدنى $10)
            </label>

            <input type="number"
                   name="amount"
                   min="10"
                   step="0.01"
                   value="{{ old('amount') }}"
                   required
                   class="w-full border rounded-lg p-3">
        </div>

        {{-- PAYER NAME --}}
        <div>
            <label class="block mb-2 font-medium">
                اسم الدافع
            </label>

            <input type="text"
                   name="payer_name"
                   value="{{ old('payer_name') }}"
                   required
                   class="w-full border rounded-lg p-3">
        </div>

        {{-- COMPANY --}}
        <div>
            <label class="block mb-2 font-medium">
                اسم الشركة (اختياري)
            </label>

            <input type="text"
                   name="company_name"
                   value="{{ old('company_name') }}"
                   class="w-full border rounded-lg p-3">
        </div>

        {{-- PAYMENT METHOD --}}
        <div>
            <label class="block mb-2 font-medium">
                طريقة الدفع
            </label>

            <select name="payment_method"
                    required
                    class="w-full border rounded-lg p-3">

                <option value="bank_transfer">تحويل بنكي</option>
                <option value="cash">نقدي</option>
                <option value="manual">يدوي (إداري)</option>

            </select>
        </div>

        {{-- RECEIPT --}}
        <div>
            <label class="block mb-2 font-medium">
                إيصال الدفع
            </label>

            <input type="file"
                   name="receipt"
                   required
                   class="w-full border rounded-lg p-3 bg-white">
        </div>

        {{-- SUBMIT --}}
        <div class="pt-3">
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg w-full">
                إرسال طلب الشحن
            </button>
        </div>

    </form>

</div>
@endsection