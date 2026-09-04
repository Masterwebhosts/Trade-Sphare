@extends('layouts.app')

@section('content')

<div class="p-6 space-y-6">

    <div>
        <h1 class="text-2xl font-bold">
            لوحة إدارة المنتجات والاشتراكات
        </h1>

        <p class="text-gray-500 text-sm mt-1">
            إدارة منتجات Trade Sphare والاشتراكات
        </p>
    </div>


    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-sm text-gray-500 mb-2">
                إجمالي المنتجات
            </h3>

            <div class="text-3xl font-bold">
                {{ $stats['products'] }}
            </div>
        </div>


        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-sm text-gray-500 mb-2">
                المنتجات النشطة
            </h3>

            <div class="text-3xl font-bold">
                {{ $stats['active_products'] }}
            </div>
        </div>


        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-sm text-gray-500 mb-2">
                إجمالي الاشتراكات
            </h3>

            <div class="text-3xl font-bold">
                {{ $stats['subscriptions'] }}
            </div>
        </div>


        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-sm text-gray-500 mb-2">
                الاشتراكات النشطة
            </h3>

            <div class="text-3xl font-bold">
                {{ $stats['active_subscriptions'] }}
            </div>
        </div>


        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-sm text-gray-500 mb-2">
                الاشتراكات المعلقة
            </h3>

            <div class="text-3xl font-bold">
                {{ $stats['pending_subscriptions'] }}
            </div>
        </div>


        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-sm text-gray-500 mb-2">
                الاشتراكات المنتهية
            </h3>

            <div class="text-3xl font-bold">
                {{ $stats['expired_subscriptions'] }}
            </div>
        </div>

    </div>


    <div class="flex flex-wrap gap-3">

        <a href="{{ route('management.products.index') }}"
           class="inline-flex items-center px-5 py-2 bg-black text-white rounded hover:bg-gray-800">

            المنتجات

        </a>


        <a href="{{ route('management.subscriptions.index') }}">
         الاشتراكات
        </a>

    </div>

</div>

@endsection