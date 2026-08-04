@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto p-6 space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                تفاصيل المستخدم
            </h1>
            <p class="text-gray-500 mt-1">
                عرض جميع بيانات المستخدم داخل شبكة الإعلانات.
            </p>
        </div>

        <a href="{{ route('admin.users.index') }}"
           class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">
            ← رجوع
        </a>
    </div>

    {{-- المعلومات الأساسية --}}
    <div class="bg-white rounded-xl shadow border">

        <div class="border-b px-6 py-4">
            <h2 class="font-bold text-lg">
                المعلومات الأساسية
            </h2>
        </div>

        <div class="grid md:grid-cols-2 gap-6 p-6">

            <div>
                <span class="font-semibold">المعرف</span>
                <div>{{ $user->id }}</div>
            </div>

            <div>
                <span class="font-semibold">الاسم</span>
                <div>{{ $user->name }}</div>
            </div>

            <div>
                <span class="font-semibold">البريد الإلكتروني</span>
                <div>{{ $user->email }}</div>
            </div>

            <div>
                <span class="font-semibold">الدور</span>

                @if($user->isAdmin())
                    <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full">
                        مدير النظام
                    </span>
                @elseif($user->isAdvertiser())
                    <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full">
                        معلن
                    </span>
                @elseif($user->isPublisher())
                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full">
                        ناشر
                    </span>
                @endif
            </div>

            <div>
                <span class="font-semibold">الحالة</span>

                @if($user->status == 'active')
                    <span class="text-green-600 font-semibold">
                        نشط
                    </span>
                @else
                    <span class="text-red-600 font-semibold">
                        {{ $user->status }}
                    </span>
                @endif
            </div>

            <div>
                <span class="font-semibold">الرصيد</span>

                <div class="text-green-600 font-bold">
                    {{ number_format($user->wallet?->balance ?? 0,2) }} $
                </div>
            </div>

            <div>
                <span class="font-semibold">تاريخ الإنشاء</span>

                <div>
                    {{ $user->created_at->format('Y-m-d H:i') }}
                </div>
            </div>

            <div>
                <span class="font-semibold">آخر تحديث</span>

                <div>
                    {{ $user->updated_at->format('Y-m-d H:i') }}
                </div>
            </div>

        </div>

    </div>



    {{-- بيانات المعلن --}}
    @if($user->isAdvertiser())

    <div class="bg-white rounded-xl shadow border p-6">

        <h2 class="font-bold text-xl mb-6">
            إحصائيات المعلن
        </h2>

        <div class="grid md:grid-cols-3 gap-5">

            <div class="bg-blue-50 rounded-lg p-5 text-center">

                <div class="text-3xl font-bold text-blue-700">
                    {{ $user->campaigns()->count() }}
                </div>

                <div class="text-gray-600 mt-2">
                    عدد الحملات
                </div>

            </div>

            <div class="bg-green-50 rounded-lg p-5 text-center">

                <div class="text-3xl font-bold text-green-700">
                    {{ number_format($user->wallet?->balance ?? 0,2) }}
                </div>

                <div class="text-gray-600 mt-2">
                    الرصيد الحالي
                </div>

            </div>

            <div class="bg-yellow-50 rounded-lg p-5 text-center">

                <div class="text-3xl font-bold text-yellow-600">
                    {{ $user->campaigns()->where('status','active')->count() }}
                </div>

                <div class="text-gray-600 mt-2">
                    الحملات النشطة
                </div>

            </div>

        </div>

    </div>

    @endif



    {{-- بيانات الناشر --}}
    @if($user->isPublisher())

    <div class="bg-white rounded-xl shadow border p-6">

        <h2 class="font-bold text-xl mb-6">
            إحصائيات الناشر
        </h2>

        <div class="grid md:grid-cols-4 gap-5">

            <div class="bg-indigo-50 rounded-lg p-5 text-center">

                <div class="text-3xl font-bold text-indigo-700">
                    {{ $user->adZones()->count() }}
                </div>

                <div class="text-gray-600 mt-2">
                    المناطق الإعلانية
                </div>

            </div>

            <div class="bg-blue-50 rounded-lg p-5 text-center">

                <div class="text-3xl font-bold text-blue-700">
                    {{ number_format($user->impressions()->count()) }}
                </div>

                <div class="text-gray-600 mt-2">
                    مرات الظهور
                </div>

            </div>

            <div class="bg-green-50 rounded-lg p-5 text-center">

                <div class="text-3xl font-bold text-green-700">
                    {{ number_format($user->clicks()->count()) }}
                </div>

                <div class="text-gray-600 mt-2">
                    النقرات
                </div>

            </div>

            <div class="bg-yellow-50 rounded-lg p-5 text-center">

                <div class="text-3xl font-bold text-yellow-700">
                    {{ $user->withdrawals()->count() }}
                </div>

                <div class="text-gray-600 mt-2">
                    طلبات السحب
                </div>

            </div>

        </div>

    </div>

    @endif



    {{-- بيانات المدير --}}
    @if($user->isAdmin())

    <div class="bg-white rounded-xl shadow border p-6">

        <h2 class="font-bold text-xl mb-6">
            معلومات مدير النظام
        </h2>

        <div class="bg-red-50 rounded-lg p-6">

            <p class="text-gray-700 leading-8">

                يمتلك هذا المستخدم صلاحيات كاملة لإدارة المنصة، بما في ذلك إدارة المستخدمين،
                الحملات الإعلانية، المناطق الإعلانية، المحافظ المالية، وطلبات السحب.

            </p>

        </div>

    </div>

    @endif

</div>

@endsection