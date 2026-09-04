@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto">

    <div class="flex items-center justify-between mb-6">

        <div>
            <h1 class="text-2xl font-bold text-gray-900">
                إضافة منتج
            </h1>

            <p class="text-gray-500 mt-1">
                إضافة منتج جديد إلى Trade Sphare
            </p>
        </div>

        <a href="{{ route('management.products.index') }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50">

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-5 h-5"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor"
                 stroke-width="2">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M15 19l-7-7 7-7"/>

            </svg>

            العودة للمنتجات

        </a>

    </div>


    @if($errors->any())

        <div class="mb-5 rounded-lg bg-red-50 border border-red-200 text-red-700 px-4 py-3">

            <ul class="list-disc list-inside space-y-1">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    <div class="bg-white rounded-xl shadow-sm border border-gray-200">

        <form method="POST"
              action="{{ route('management.products.store') }}"
              class="p-6 space-y-6">

            @csrf


            {{-- اسم المنتج --}}

            <div>

                <label for="name"
                       class="block text-sm font-medium text-gray-700 mb-2">
                    اسم المنتج
                </label>

                <input type="text"
                       id="name"
                       name="name"
                       value="{{ old('name') }}"
                       required
                       class="w-full rounded-lg border-gray-300 focus:border-black focus:ring-black"
                       placeholder="مثال: Trade Sphare CRM">

            </div>


            {{-- الرابط --}}

            <div>

                <label for="slug"
                       class="block text-sm font-medium text-gray-700 mb-2">
                    Slug
                </label>

                <input type="text"
                       id="slug"
                       name="slug"
                       value="{{ old('slug') }}"
                       class="w-full rounded-lg border-gray-300 focus:border-black focus:ring-black"
                       placeholder="trade-sphare-crm">

                <p class="text-xs text-gray-500 mt-1">
                    اتركه فارغًا لإنشائه تلقائيًا من اسم المنتج.
                </p>

            </div>


            {{-- الوصف --}}

            <div>

                <label for="description"
                       class="block text-sm font-medium text-gray-700 mb-2">
                    الوصف
                </label>

                <textarea id="description"
                          name="description"
                          rows="5"
                          class="w-full rounded-lg border-gray-300 focus:border-black focus:ring-black"
                          placeholder="وصف المنتج...">{{ old('description') }}</textarea>

            </div>


            {{-- النوع والسعر --}}

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

                <div>

                    <label for="type"
                           class="block text-sm font-medium text-gray-700 mb-2">
                        نوع المنتج
                    </label>

                    <select id="type"
                            name="type"
                            required
                            class="w-full rounded-lg border-gray-300 focus:border-black focus:ring-black">

                        <option value="digital"
                            {{ old('type', 'digital') === 'digital' ? 'selected' : '' }}>
                            منتج رقمي
                        </option>

                        <option value="plugin"
                            {{ old('type') === 'plugin' ? 'selected' : '' }}>
                            إضافة WordPress
                        </option>

                        <option value="theme"
                            {{ old('type') === 'theme' ? 'selected' : '' }}>
                            قالب
                        </option>

                        <option value="template"
                            {{ old('type') === 'template' ? 'selected' : '' }}>
                            Template
                        </option>

                        <option value="service"
                            {{ old('type') === 'service' ? 'selected' : '' }}>
                            خدمة
                        </option>

                    </select>

                </div>


                <div>

                    <label for="price"
                           class="block text-sm font-medium text-gray-700 mb-2">
                        السعر
                    </label>

                    <input type="number"
                           id="price"
                           name="price"
                           value="{{ old('price', '0.00') }}"
                           min="0"
                           step="0.01"
                           required
                           class="w-full rounded-lg border-gray-300 focus:border-black focus:ring-black">

                </div>


                <div>

                    <label for="currency"
                           class="block text-sm font-medium text-gray-700 mb-2">
                        العملة
                    </label>

                    <select id="currency"
                            name="currency"
                            required
                            class="w-full rounded-lg border-gray-300 focus:border-black focus:ring-black">

                        <option value="USD"
                            {{ old('currency', 'USD') === 'USD' ? 'selected' : '' }}>
                            USD
                        </option>

                        <option value="EUR"
                            {{ old('currency') === 'EUR' ? 'selected' : '' }}>
                            EUR
                        </option>

                        <option value="SYP"
                            {{ old('currency') === 'SYP' ? 'selected' : '' }}>
                            SYP
                        </option>

                    </select>

                </div>

            </div>


            {{-- خيارات المنتج --}}

            <div class="border-t border-gray-200 pt-5 space-y-4">

                <label class="flex items-center gap-3 cursor-pointer">

                    <input type="checkbox"
                           name="is_subscription"
                           value="1"
                           {{ old('is_subscription') ? 'checked' : '' }}
                           class="rounded border-gray-300 text-black focus:ring-black">

                    <span class="text-sm text-gray-700">
                        هذا المنتج اشتراك
                    </span>

                </label>


                <label class="flex items-center gap-3 cursor-pointer">

                    <input type="checkbox"
                           name="is_active"
                           value="1"
                           {{ old('is_active', true) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-black focus:ring-black">

                    <span class="text-sm text-gray-700">
                        المنتج نشط
                    </span>

                </label>

            </div>


            {{-- الأزرار --}}

            <div class="flex items-center justify-end gap-3 border-t border-gray-200 pt-5">

                <a href="{{ route('management.products.index') }}"
                   class="px-5 py-2.5 rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50">
                    إلغاء
                </a>

                <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-black text-white hover:bg-gray-800">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="w-5 h-5"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="2">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M5 13l4 4L19 7"/>

                    </svg>

                    حفظ المنتج

                </button>

            </div>

        </form>

    </div>

</div>

@endsection