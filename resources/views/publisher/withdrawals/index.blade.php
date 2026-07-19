@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto p-6 space-y-6">

    {{-- HEADER --}}
    <div>
        <h1 class="text-2xl font-bold">طلبات السحب</h1>
        <p class="text-gray-500 mt-1">إدارة طلبات السحب من الرصيد المتاح</p>
    </div>

    {{-- BALANCE --}}
    <div class="bg-white shadow rounded-xl p-5">
        <div class="text-sm text-gray-500">الرصيد المتاح</div>
        <div class="text-3xl font-bold text-green-600">
            ${{ number_format($balance, 4) }}
        </div>
    </div>

    {{-- MINIMUM WARNING --}}
    @if($balance < 10)
        <div class="p-3 bg-red-50 border border-red-200 text-red-700 rounded-lg">
            الحد الأدنى للسحب هو 10$
        </div>
    @endif

    {{-- ERRORS --}}
    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 p-3 rounded-lg">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FORM --}}
    <div class="bg-white shadow rounded-xl p-5">

        <form method="POST"
              action="{{ route('publisher.withdrawals.store') }}"
              class="space-y-4">

            @csrf

            {{-- NAME --}}
            <input
                type="text"
                name="name"
                required
                class="w-full border rounded-lg p-3"
                placeholder="الاسم الكامل"
                {{ $balance < 10 ? 'disabled' : '' }}
            >

            {{-- EMAIL --}}
            <input
                type="email"
                name="email"
                required
                class="w-full border rounded-lg p-3"
                placeholder="البريد الإلكتروني"
                {{ $balance < 10 ? 'disabled' : '' }}
            >

            {{-- PHONE --}}
            <input
                type="text"
                name="phone"
                required
                class="w-full border rounded-lg p-3"
                placeholder="رقم الهاتف"
                {{ $balance < 10 ? 'disabled' : '' }}
            >

            {{-- METHOD --}}
            <select
                name="method"
                required
                class="w-full border rounded-lg p-3"
                {{ $balance < 10 ? 'disabled' : '' }}
            >
                <option value="">طريقة الاستلام</option>
                <option value="bank">تحويل بنكي</option>
                <option value="wallet">محفظة محلية</option>
            </select>

            {{-- AMOUNT --}}
            <input
                type="number"
                name="amount"
                min="10"
                step="0.01"
                required
                class="w-full border rounded-lg p-3"
                placeholder="أدخل المبلغ"
                {{ $balance < 10 ? 'disabled' : '' }}
            >

            {{-- SUBMIT --}}
            <button
                type="submit"
                class="w-full px-4 py-3 rounded-lg text-white font-medium
                {{ $balance < 10 ? 'bg-gray-400 cursor-not-allowed' : 'bg-blue-600 hover:bg-blue-700' }}"
                {{ $balance < 10 ? 'disabled' : '' }}
            >
                إرسال طلب السحب
            </button>

        </form>

    </div>

</div>

@endsection