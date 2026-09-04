@extends('layouts.app')

@section('content')

<div class="p-6 space-y-6">

    <div class="flex items-center justify-between">

        <div>
            <h1 class="text-2xl font-bold">
                إضافة اشتراك
            </h1>

            <p class="text-gray-500 text-sm mt-1">
                إنشاء اشتراك جديد لمنتج من منتجات Trade Sphare
            </p>
        </div>

        <a href="{{ route('management.subscriptions.index') }}"
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

            العودة للاشتراكات

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
              action="{{ route('management.subscriptions.store') }}"
              class="space-y-6">

            @csrf


            {{-- المستخدم والمنتج --}}

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>

                    <label class="block text-sm font-medium mb-2">
                        المستخدم
                    </label>

                    <select name="user_id"
                            required
                            class="w-full border border-gray-300 rounded px-3 py-2">

                        <option value="">
                            اختر المستخدم
                        </option>

                        @foreach($users as $user)

                            <option value="{{ $user->id }}"
                                {{ old('user_id') == $user->id ? 'selected' : '' }}>

                                {{ $user->name }}
                                @if($user->email)
                                    — {{ $user->email }}
                                @endif

                            </option>

                        @endforeach

                    </select>

                </div>


                <div>

                    <label class="block text-sm font-medium mb-2">
                        المنتج
                    </label>

                    <select name="product_id"
                            required
                            class="w-full border border-gray-300 rounded px-3 py-2">

                        <option value="">
                            اختر المنتج
                        </option>

                        @foreach($products as $product)

                            <option value="{{ $product->id }}"
                                {{ old('product_id') == $product->id ? 'selected' : '' }}>

                                {{ $product->name }}
                                — {{ $product->price }} {{ $product->currency }}

                            </option>

                        @endforeach

                    </select>

                </div>

            </div>


            {{-- الحالة --}}

            <div>

                <label class="block text-sm font-medium mb-2">
                    حالة الاشتراك
                </label>

                <select name="status"
                        required
                        class="w-full border border-gray-300 rounded px-3 py-2">

                    <option value="pending"
                        {{ old('status', 'pending') === 'pending' ? 'selected' : '' }}>
                        معلق
                    </option>

                    <option value="active"
                        {{ old('status') === 'active' ? 'selected' : '' }}>
                        نشط
                    </option>

                    <option value="expired"
                        {{ old('status') === 'expired' ? 'selected' : '' }}>
                        منتهي
                    </option>

                    <option value="cancelled"
                        {{ old('status') === 'cancelled' ? 'selected' : '' }}>
                        ملغي
                    </option>

                    <option value="suspended"
                        {{ old('status') === 'suspended' ? 'selected' : '' }}>
                        موقوف
                    </option>

                </select>

            </div>


            {{-- التواريخ --}}

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>

                    <label class="block text-sm font-medium mb-2">
                        تاريخ البداية
                    </label>

                    <input type="datetime-local"
                           name="starts_at"
                           value="{{ old('starts_at') }}"
                           class="w-full border border-gray-300 rounded px-3 py-2">

                </div>


                <div>

                    <label class="block text-sm font-medium mb-2">
                        تاريخ النهاية
                    </label>

                    <input type="datetime-local"
                           name="ends_at"
                           value="{{ old('ends_at') }}"
                           class="w-full border border-gray-300 rounded px-3 py-2">

                </div>

            </div>


            {{-- السعر والعملة --}}

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>

                    <label class="block text-sm font-medium mb-2">
                        السعر
                    </label>

                    <input type="number"
                           name="price"
                           value="{{ old('price', 0) }}"
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


            {{-- External ID --}}

            <div>

                <label class="block text-sm font-medium mb-2">
                    External ID
                </label>

                <input type="text"
                       name="external_id"
                       value="{{ old('external_id') }}"
                       placeholder="اختياري"
                       class="w-full border border-gray-300 rounded px-3 py-2">

                <p class="text-xs text-gray-500 mt-1">
                    معرف خارجي للاشتراك إذا كان قادمًا من نظام آخر.
                </p>

            </div>


            {{-- الأزرار --}}

            <div class="flex justify-end gap-3 border-t pt-5">

                <a href="{{ route('management.subscriptions.index') }}"
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

                    حفظ الاشتراك

                </button>

            </div>

        </form>

    </div>

</div>

@endsection