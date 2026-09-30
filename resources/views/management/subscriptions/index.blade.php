@extends('layouts.app')

@section('content')

<div class="p-6 space-y-6">

    <div class="flex items-center justify-between">

        <div>
            <h1 class="text-2xl font-bold">
                الاشتراكات
            </h1>

            <p class="text-gray-500 text-sm mt-1">
                إدارة اشتراكات منتجات Trade Sphare
            </p>
        </div>

        <a href="{{ route('management.subscriptions.create') }}"
           class="inline-flex items-center gap-2 bg-black text-white px-4 py-2 rounded hover:bg-gray-800">

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-5 h-5"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor"
                 stroke-width="2">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M12 4v16m8-8H4"/>

            </svg>

            إضافة اشتراك

        </a>

    </div>


    @if(session('success'))

        <div class="bg-green-50 border border-green-200 text-green-700 p-4 rounded">
            {{ session('success') }}
        </div>

    @endif


    <div class="bg-white rounded shadow overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full text-right">

                <thead class="bg-gray-50 border-b">

                    <tr>

                        <th class="px-4 py-3 text-sm font-semibold">
                            المستخدم
                        </th>

                        <th class="px-4 py-3 text-sm font-semibold">
                            المنتج
                        </th>

                        <th class="px-4 py-3 text-sm font-semibold">
                            السعر
                        </th>

                        <th class="px-4 py-3 text-sm font-semibold">
                            الحالة
                        </th>

                        <th class="px-4 py-3 text-sm font-semibold">
                            البداية
                        </th>

                        <th class="px-4 py-3 text-sm font-semibold">
                            النهاية
                        </th>

                        <th class="px-4 py-3 text-sm font-semibold">
                            الإجراءات
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y">

                    @forelse($subscriptions as $subscription)

                        <tr class="hover:bg-gray-50">

                            <td class="px-4 py-4">

                                <div class="font-semibold">
                                    {{ $subscription->user?->name ?? '—' }}
                                </div>

                                @if($subscription->user?->email)

                                    <div class="text-xs text-gray-500 mt-1">
                                        {{ $subscription->user->email }}
                                    </div>

                                @endif

                            </td>


                            <td class="px-4 py-4">

                                <div class="font-semibold">
                                    {{ $subscription->product?->name ?? '—' }}
                                </div>

                            </td>


                            <td class="px-4 py-4 font-semibold">

                                {{ $subscription->price }}
                                {{ $subscription->currency }}

                            </td>


                            <td class="px-4 py-4">

                                @switch($subscription->status)

                                    @case('active')

                                        <span class="inline-block bg-green-100 text-green-700 text-xs px-2 py-1 rounded">
                                            نشط
                                        </span>

                                        @break

                                    @case('pending')

                                        <span class="inline-block bg-yellow-100 text-yellow-700 text-xs px-2 py-1 rounded">
                                            معلق
                                        </span>

                                        @break

                                    @case('expired')

                                        <span class="inline-block bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded">
                                            منتهي
                                        </span>

                                        @break

                                    @case('cancelled')

                                        <span class="inline-block bg-red-100 text-red-700 text-xs px-2 py-1 rounded">
                                            ملغي
                                        </span>

                                        @break

                                    @case('suspended')

                                        <span class="inline-block bg-orange-100 text-orange-700 text-xs px-2 py-1 rounded">
                                            موقوف
                                        </span>

                                        @break

                                    @default

                                        <span class="inline-block bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded">
                                            {{ $subscription->status }}
                                        </span>

                                @endswitch

                            </td>


                            <td class="px-4 py-4 text-sm">

                                {{ $subscription->starts_at?->format('Y-m-d') ?? '—' }}

                            </td>


                            <td class="px-4 py-4 text-sm">

                                {{ $subscription->ends_at?->format('Y-m-d') ?? '—' }}

                            </td>


                            <td class="px-4 py-4">

                                <div class="flex items-center gap-2">

                                    <a href="{{ route('management.subscriptions.edit', $subscription) }}"
                                       title="تعديل الاشتراك"
                                       class="p-2 rounded hover:bg-blue-50 text-blue-600">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             class="w-5 h-5"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke="currentColor"
                                             stroke-width="2">

                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5"/>

                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>

                                        </svg>

                                    </a>


                                    <form method="POST"
                                          action="{{ route('management.subscriptions.destroy', $subscription) }}"
                                          onsubmit="return confirm('هل أنت متأكد من حذف هذا الاشتراك؟');">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                title="حذف الاشتراك"
                                                class="p-2 rounded hover:bg-red-50 text-red-600">

                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 class="w-5 h-5"
                                                 fill="none"
                                                 viewBox="0 0 24 24"
                                                 stroke="currentColor"
                                                 stroke-width="2">

                                                <path stroke-linecap="round"
                                                      stroke-linejoin="round"
                                                      d="M6 7h12"/>

                                                <path stroke-linecap="round"
                                                      stroke-linejoin="round"
                                                      d="M10 11v6"/>

                                                <path stroke-linecap="round"
                                                      stroke-linejoin="round"
                                                      d="M14 11v6"/>

                                                <path stroke-linecap="round"
                                                      stroke-linejoin="round"
                                                      d="M9 7V4h6v3"/>

                                                <path stroke-linecap="round"
                                                      stroke-linejoin="round"
                                                      d="M5 7l1 14h12l1-14"/>

                                            </svg>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7"
                                class="px-4 py-12 text-center text-gray-500">

                                <p class="font-medium">
                                    لا توجد اشتراكات حاليًا
                                </p>

                                <a href="{{ route('management.subscriptions.create') }}"
                                   class="inline-block mt-3 text-blue-600 hover:underline">

                                    إضافة أول اشتراك

                                </a>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        @if($subscriptions->hasPages())

            <div class="px-4 py-4 border-t">
                {{ $subscriptions->links() }}
            </div>

        @endif

    </div>

</div>

@endsection