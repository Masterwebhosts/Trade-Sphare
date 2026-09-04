@extends('layouts.app')

@section('content')

<div class="p-6 space-y-6">

    <div class="flex items-center justify-between">

        <div>
            <h1 class="text-2xl font-bold">
                تعديل المنتج
            </h1>

            <p class="text-gray-500 text-sm mt-1">
                {{ $product->name }}
            </p>
        </div>

        <a href="{{ route('management.products.index') }}"
           class="inline-flex items-center gap-2 bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-700">

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

        <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded">

            <ul class="list-disc list-inside space-y-1">

                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif


    <div class="bg-white p-6 rounded shadow">

        <form method="POST"
              action="{{ route('management.products.update', $product) }}"
              class="space-y-6">

            @csrf
            @method('PUT')


            {{-- اسم المنتج --}}

            <div>

                <label class="block text-sm font-medium mb-2">
                    اسم المنتج
                </label>

                <input type="text"
                       name="name"
                       value="{{ old('name', $product->name) }}"
                       required
                       class="w-full border border-gray-300 rounded px-3 py-2">

            </div>


            {{-- Slug --}}

            <div>

                <label class="block text-sm font-medium mb-2">
                    Slug
                </label>

                <input type="text"
                       name="slug"
                       value="{{ old('slug', $product->slug) }}"
                       required
                       class="w-full border border-gray-300 rounded px-3 py-2">

            </div>


            {{-- الوصف --}}

            <div>

                <label class="block text-sm font-medium mb-2">
                    الوصف
                </label>

                <textarea name="description"
                          rows="5"
                          class="w-full border border-gray-300 rounded px-3 py-2">{{ old('description', $product->description) }}</textarea>

            </div>


            {{-- النوع --}}

            <div>

                <label class="block text-sm font-medium mb-2">
                    نوع المنتج
                </label>

                <select name="type"
                        required
                        class="w-full border border-gray-300 rounded px-3 py-2">

                    <option value="digital"
                        {{ old('type', $product->type) === 'digital' ? 'selected' : '' }}>
                        منتج رقمي
                    </option>

                    <option value="plugin"
                        {{ old('type', $product->type) === 'plugin' ? 'selected' : '' }}>
                        إضافة WordPress
                    </option>

                    <option value="theme"
                        {{ old('type', $product->type) === 'theme' ? 'selected' : '' }}>
                        قالب
                    </option>

                    <option value="template"
                        {{ old('type', $product->type) === 'template' ? 'selected' : '' }}>
                        Template
                    </option>

                    <option value="service"
                        {{ old('type', $product->type) === 'service' ? 'selected' : '' }}>
                        خدمة
                    </option>

                </select>

            </div>


            {{-- السعر والعملة --}}

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>

                    <label class="block text-sm font-medium mb-2">
                        السعر
                    </label>

                    <input type="number"
                           name="price"
                           value="{{ old('price', $product->price) }}"
                           min="0"
                           step="0.01"
                           required
                           class="w-full border border-gray-300 rounded px-3 py-2">

                </div>


                <div>

                    <label class="block text-sm font-medium mb-2">
                        العملة
                    </label>

                    <select name="currency"
                            required
                            class="w-full border border-gray-300 rounded px-3 py-2">

                        <option value="USD"
                            {{ old('currency', $product->currency) === 'USD' ? 'selected' : '' }}>
                            USD
                        </option>

                        <option value="EUR"
                            {{ old('currency', $product->currency) === 'EUR' ? 'selected' : '' }}>
                            EUR
                        </option>

                        <option value="SYP"
                            {{ old('currency', $product->currency) === 'SYP' ? 'selected' : '' }}>
                            SYP
                        </option>

                    </select>

                </div>

            </div>


            {{-- الخيارات --}}

            <div class="border-t pt-5 space-y-4">

                <label class="flex items-center gap-2">

                    <input type="checkbox"
                           name="is_subscription"
                           value="1"
                           {{ old('is_subscription', $product->is_subscription) ? 'checked' : '' }}>

                    <span>
                        المنتج اشتراك
                    </span>

                </label>


                <label class="flex items-center gap-2">

                    <input type="checkbox"
                           name="is_active"
                           value="1"
                           {{ old('is_active', $product->is_active) ? 'checked' : '' }}>

                    <span>
                        المنتج نشط
                    </span>

                </label>

            </div>


            {{-- حفظ --}}

            <div class="flex justify-end gap-3 border-t pt-5">

                <a href="{{ route('management.products.index') }}"
                   class="px-5 py-2 border border-gray-300 rounded bg-white hover:bg-gray-50">
                    إلغاء
                </a>

                <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2 bg-black text-white rounded hover:bg-gray-800">

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

                    حفظ التعديلات

                </button>

            </div>

        </form>

    </div>

</div>

@endsection