@extends('layouts.app')

@section('content')

<div class="p-6 space-y-6">

    <div>
        <h1 class="text-2xl font-bold text-gray-900">
            الإعلانات
        </h1>

        <p class="text-sm text-gray-500 mt-1">
            إدارة ومراجعة جميع الإعلانات وحالاتها التشغيلية
        </p>
    </div>


    @php

        $stateLabels = [

            'pending_review' => 'بانتظار المراجعة',

            'active' => 'نشط',

            'rejected' => 'مرفوض',

            'paused' => 'متوقف',

            'deleted' => 'محذوف',

        ];



        $stateColors = [

            'pending_review' => 'text-yellow-600',

            'active' => 'text-green-600',

            'rejected' => 'text-red-600',

            'paused' => 'text-gray-500',

            'deleted' => 'text-gray-400',

        ];

    @endphp



    <div class="bg-white rounded-xl shadow-sm border overflow-x-auto">


        <table class="w-full text-sm">


            <thead class="bg-gray-50 border-b text-gray-600">

                <tr>

                    <th class="p-3 text-right">
                        المعرف
                    </th>

                    <th class="p-3 text-right">
                        عنوان الإعلان
                    </th>

                    <th class="p-3 text-right">
                        الحملة
                    </th>

                    <th class="p-3 text-right">
                        الحالة
                    </th>

                    <th class="p-3 text-left">
                        الإجراءات
                    </th>

                </tr>

            </thead>



            <tbody>


            @forelse($ads as $ad)

                @php

                    $status = $ad->status ?? 'pending_review';

                @endphp



                <tr class="border-b hover:bg-gray-50 transition">


                    <td class="p-3">

                        #{{ $ad->id }}

                    </td>



                    <td class="p-3 font-medium text-gray-900">

                        {{ $ad->title ?: 'بدون عنوان' }}

                    </td>



                    <td class="p-3 text-gray-600">

                        {{ $ad->campaign?->title ?? 'بدون حملة' }}

                    </td>



                    <td class="p-3">

                        <span class="{{ $stateColors[$status] ?? 'text-gray-500' }}">

                            {{ $stateLabels[$status] ?? $status }}

                        </span>

                    </td>



                    <td class="p-3">

                        <div class="flex justify-end gap-4">


                            <a href="{{ route('admin.ads.show', $ad->id) }}"
                               class="text-blue-600 hover:underline">

                                عرض

                            </a>



                            <a href="{{ route('admin.ads.moderation', $ad->id) }}"
                               class="text-yellow-600 hover:underline">

                                مراجعة

                            </a>


                        </div>

                    </td>


                </tr>


            @empty


                <tr>

                    <td colspan="5"
                        class="text-center py-10 text-gray-500">

                        لا توجد إعلانات حالياً

                    </td>

                </tr>


            @endforelse


            </tbody>


        </table>


    </div>


</div>


@endsection