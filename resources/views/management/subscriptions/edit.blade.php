@extends('layouts.app')

@section('content')

<div class="p-6 space-y-6">

    {{-- العنوان --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                تعديل الاشتراك
            </h1>

            <p class="text-gray-500 mt-1">
                تعديل بيانات اشتراك المستخدم والمنتج.
            </p>
        </div>

        <a
            href="{{ route('management.subscriptions.index') }}"
            class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg"
        >
            العودة للاشتراكات
        </a>
    </div>

    {{-- الأخطاء --}}
    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg p-4">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- النموذج --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">

        <form
            method="POST"
            action="{{ route('management.subscriptions.update', $subscription) }}"
            class="space-y-6"
        >

            @csrf
            @method('PUT')

            {{-- المستخدم --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    المستخدم
                </label>

                <select
                    name="user_id"
                    required
                    class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                >
                    @foreach ($users as $user)
                        <option
                            value="{{ $user->id }}"
                            @selected(old('user_id', $subscription->user_id) == $user->id)
                        >
                            {{ $user->name }}
                            @if($user->email)
                                — {{ $user->email }}
                            @endif
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- المنتج --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    المنتج
                </label>

                <select
                    name="product_id"
                    required
                    class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                >
                    @foreach ($products as $product)
                        <option
                            value="{{ $product->id }}"
                            @selected(old('product_id', $subscription->product_id) == $product->id)
                        >
                            {{ $product->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- الحالة --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    حالة الاشتراك
                </label>

                <select
                    name="status"
                    required
                    class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                >
                    <option value="pending"
                        @selected(old('status', $subscription->status) === 'pending')>
                        معلق
                    </option>

                    <option value="active"
                        @selected(old('status', $subscription->status) === 'active')>
                        نشط
                    </option>

                    <option value="expired"
                        @selected(old('status', $subscription->status) === 'expired')>
                        منتهي
                    </option>

                    <option value="cancelled"
                        @selected(old('status', $subscription->status) === 'cancelled')>
                        ملغي
                    </option>

                    <option value="suspended"
                        @selected(old('status', $subscription->status) === 'suspended')>
                        موقوف
                    </option>
                </select>
            </div>

            {{-- التواريخ --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        تاريخ بداية الاشتراك
                    </label>

                    <input
                        type="datetime-local"
                        name="starts_at"
                        value="{{ old('starts_at', $subscription->starts_at?->format('Y-m-d\TH:i')) }}"
                        class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        تاريخ انتهاء الاشتراك
                    </label>

                    <input
                        type="datetime-local"
                        name="ends_at"
                        value="{{ old('ends_at', $subscription->ends_at?->format('Y-m-d\TH:i')) }}"
                        class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                    >
                </div>

            </div>

            {{-- السعر والعملة --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        السعر
                    </label>

                    <input
                        type="number"
                        name="price"
                        step="0.01"
                        min="0"
                        required
                        value="{{ old('price', $subscription->price) }}"
                        class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        العملة
                    </label>

                    <select
                        name="currency"
                        required
                        class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                    >
                        <option value="USD"
                            @selected(old('currency', $subscription->currency) === 'USD')>
                            USD — دولار أمريكي
                        </option>

                        <option value="EUR"
                            @selected(old('currency', $subscription->currency) === 'EUR')>
                            EUR — يورو
                        </option>

                        <option value="SYP"
                            @selected(old('currency', $subscription->currency) === 'SYP')>
                            SYP — ليرة سورية
                        </option>
                    </select>
                </div>

            </div>

            {{-- External ID --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    External ID
                </label>

                <input
                    type="text"
                    name="external_id"
                    value="{{ old('external_id', $subscription->external_id) }}"
                    class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="اختياري"
                >

                <p class="text-xs text-gray-500 mt-1">
                    معرف خارجي للاشتراك إذا كان مرتبطاً بنظام دفع أو خدمة أخرى.
                </p>
            </div>

            {{-- الأزرار --}}
            <div class="flex items-center gap-3 pt-4 border-t">

                <button
                    type="submit"
                    class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium"
                >
                    حفظ التعديلات
                </button>

                <a
                    href="{{ route('management.subscriptions.index') }}"
                    class="px-6 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg"
                >
                    إلغاء
                </a>

            </div>

        </form>

    </div>

</div>

@endsection