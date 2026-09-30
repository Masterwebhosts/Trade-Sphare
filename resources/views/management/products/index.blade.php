@extends('layouts.app')

@section('content')

<div class="p-6 space-y-6">

    <div class="flex items-center justify-between">

        <div>
            <h1 class="text-2xl font-bold">
                المنتجات
            </h1>

            <p class="text-gray-500 text-sm mt-1">
                إدارة منتجات Trade Sphare
            </p>
        </div>

        <a href="{{ route('management.products.create') }}"
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

            إضافة منتج

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
                            المنتج
                        </th>

                        <th class="px-4 py-3 text-sm font-semibold">
                            النوع
                        </th>

                        <th class="px-4 py-3 text-sm font-semibold">
                            السعر
                        </th>

                        <th class="px-4 py-3 text-sm font-semibold">
                            الاشتراك
                        </th>

                        <th class="px-4 py-3 text-sm font-semibold">
                            الحالة
                        </th>

                        <th class="px-4 py-3 text-sm font-semibold">
                            الإجراءات
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y">

                    @forelse($products as $product)

                        <tr class="hover:bg-gray-50">

                            <td class="px-4 py-4">

                                <div class="font-semibold">
                                    {{ $product->name }}
                                </div>

                                <div class="text-xs text-gray-500 mt-1">
                                    {{ $product->slug }}
                                </div>

                            </td>


                            <td class="px-4 py-4">

                                @switch($product->type)

                                    @case('plugin')
                                        إضافة WordPress
                                        @break

                                    @case('theme')
                                        قالب
                                        @break

                                    @case('template')
                                        Template
                                        @break

                                    @case('service')
                                        خدمة
                                        @break

                                    @default
                                        منتج رقمي

                                @endswitch

                            </td>


                            <td class="px-4 py-4 font-semibold">

                                {{ $product->price }}
                                {{ $product->currency }}

                            </td>


                            <td class="px-4 py-4">

                                @if($product->is_subscription)

                                    <span class="inline-block bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded">
                                        اشتراك
                                    </span>

                                @else

                                    <span class="inline-block bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded">
                                        عادي
                                    </span>

                                @endif

                            </td>


                            <td class="px-4 py-4">

                                @if($product->is_active)

                                    <span class="inline-block bg-green-100 text-green-700 text-xs px-2 py-1 rounded">
                                        نشط
                                    </span>

                                @else

                                    <span class="inline-block bg-red-100 text-red-700 text-xs px-2 py-1 rounded">
                                        معطل
                                    </span>

                                @endif

                            </td>


                            <td class="px-4 py-4">

                                <div class="flex items-center gap-2">

                                    <a href="{{ route('management.products.edit', $product) }}"
                                       title="تعديل المنتج"
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
                                          action="{{ route('management.products.toggle', $product) }}">

                                        @csrf
                                        @method('PATCH')

                                        <button type="submit"
                                                title="{{ $product->is_active ? 'تعطيل المنتج' : 'تفعيل المنتج' }}"
                                                class="p-2 rounded hover:bg-yellow-50 text-yellow-600">

                                            @if($product->is_active)

                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                     class="w-5 h-5"
                                                     fill="none"
                                                     viewBox="0 0 24 24"
                                                     stroke="currentColor"
                                                     stroke-width="2">

                                                    <path stroke-linecap="round"
                                                          stroke-linejoin="round"
                                                          d="M18.364 5.636A9 9 0 015.636 18.364"/>

                                                    <path stroke-linecap="round"
                                                          stroke-linejoin="round"
                                                          d="M5.636 5.636l12.728 12.728"/>

                                                </svg>

                                            @else

                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                     class="w-5 h-5"
                                                     fill="none"
                                                     viewBox="0 0 24 24"
                                                     stroke="currentColor"
                                                     stroke-width="2">

                                                    <path stroke-linecap="round"
                                                          stroke-linejoin="round"
                                                          d="M9 12l2 2 4-4"/>

                                                    <path stroke-linecap="round"
                                                          stroke-linejoin="round"
                                                          d="M12 3a9 9 0 100 18 9 9 0 000-18z"/>

                                                </svg>

                                            @endif

                                        </button>

                                    </form>


                                    <form method="POST"
                                          action="{{ route('management.products.destroy', $product) }}"
                                          onsubmit="return confirm('هل أنت متأكد من حذف هذا المنتج؟');">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                title="حذف المنتج"
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

                            <td colspan="6"
                                class="px-4 py-12 text-center text-gray-500">

                                <p class="font-medium">
                                    لا توجد منتجات حاليًا
                                </p>

                                <a href="{{ route('management.products.create') }}"
                                   class="inline-block mt-3 text-blue-600 hover:underline">

                                    إضافة أول منتج

                                </a>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        @if($products->hasPages())

            <div class="px-4 py-4 border-t">
                {{ $products->links() }}
            </div>

        @endif

    </div>

</div>

@endsection