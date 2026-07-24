@extends('layouts.app')

@section('content')

<div class="p-6 space-y-6">

    <h1 class="text-2xl font-bold text-gray-900">
        لوحة التحكم المالية
    </h1>


    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">


        {{-- TOP UPS --}}
        <div class="bg-white rounded-xl shadow p-6">

            <div class="text-gray-500 text-sm">
                إجمالي عمليات الشحن
            </div>

            <div class="text-3xl font-bold text-green-600 mt-2">
                ${{ number_format($totalTopUps, 2) }}
            </div>

        </div>



        {{-- WITHDRAWALS --}}
        <div class="bg-white rounded-xl shadow p-6">

            <div class="text-gray-500 text-sm">
                إجمالي عمليات السحب
            </div>

            <div class="text-3xl font-bold text-red-600 mt-2">
               ${{ number_format($totalWithdrawals, 6) }}
            </div>

        </div>



        {{-- PLATFORM REVENUE --}}
        <div class="bg-white rounded-xl shadow p-6">

            <div class="text-gray-500 text-sm">
                أرباح المنصة
            </div>

            <div class="text-3xl font-bold text-blue-600 mt-2">
                ${{ number_format($platformRevenue, (round($platformRevenue, 2) != $platformRevenue ? 3 : 2)) }}
            </div>

        </div>



        {{-- TOTAL TRANSACTIONS --}}
        <div class="bg-white rounded-xl shadow p-6">

            <div class="text-gray-500 text-sm">
                إجمالي العمليات
            </div>

            <div class="text-3xl font-bold text-indigo-600 mt-2">
                {{ $totalTransactions }}
            </div>

        </div>



        {{-- PENDING TOPUPS --}}
        <div class="bg-white rounded-xl shadow p-6">

            <div class="text-gray-500 text-sm">
                عمليات الشحن المعلقة
            </div>

            <div class="text-3xl font-bold text-yellow-600 mt-2">
                {{ $pendingTopups }}
            </div>

        </div>



        {{-- PENDING WITHDRAWALS --}}
        <div class="bg-white rounded-xl shadow p-6">

            <div class="text-gray-500 text-sm">
                عمليات السحب المعلقة
            </div>

            <div class="text-3xl font-bold text-orange-600 mt-2">
                {{ $pendingWithdrawals }}
            </div>

        </div>


    </div>


</div>

@endsection