@extends('layouts.app')

@section('content')

<div class="p-6 space-y-6">

    <div>
        <h1 class="text-2xl font-bold text-gray-900">
            إدارة الحملات الإعلانية
        </h1>

        <p class="text-sm text-gray-500 mt-1">
            متابعة الميزانيات والحالة التشغيلية لكل حملة
        </p>
    </div>


    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead class="bg-gray-50 border-b text-gray-600">

                    <tr>

                        <th class="p-4 text-right">#</th>

                        <th class="p-4 text-right">
                            اسم الحملة
                        </th>

                        <th class="p-4 text-right">
                            الحالة
                        </th>

                        <th class="p-4 text-right">
                            الميزانية
                        </th>

                        <th class="p-4 text-right">
                            المصروف
                        </th>

                        <th class="p-4 text-right">
                            المتبقي
                        </th>

                        <th class="p-4 text-right">
                            نسبة الاستهلاك
                        </th>

                        <th class="p-4 text-right">
                            تاريخ الإنشاء
                        </th>

                        <th class="p-4 text-right">
                            الإجراءات
                        </th>

                    </tr>

                </thead>


                <tbody>


                @forelse($campaigns as $campaign)

                    @php

                        $budget = (float) ($campaign->budget_total ?? 0);

                        $spent = (float) ($campaign->budget_spent ?? 0);

                        $remaining = (float) ($campaign->budget_remaining ?? 0);


                        $usage = $budget > 0
                            ? round(($spent / $budget) * 100)
                            : 0;



                        $status = $campaign->status ?? 'pending';



                        $statusLabel = match($status) {

                            'pending'
                                => 'بانتظار المراجعة',

                            'approved'
                                => 'تمت الموافقة',

                            'rejected'
                                => 'مرفوضة',

                            'active'
                                => 'نشطة',

                            'paused'
                                => 'متوقفة',

                            'completed'
                                => 'مكتملة',

                            'draft'
                                => 'مسودة',

                            default
                                => $status,

                        };



                        $class = match($status) {

                            'approved',
                            'active'
                                => 'bg-green-100 text-green-700',


                            'pending'
                                => 'bg-yellow-100 text-yellow-700',


                            'rejected'
                                => 'bg-red-100 text-red-700',


                            'paused'
                                => 'bg-orange-100 text-orange-700',


                            'completed'
                                => 'bg-blue-100 text-blue-700',


                            default
                                => 'bg-gray-100 text-gray-700',

                        };


                    @endphp



                    <tr class="border-b hover:bg-gray-50">


                        <td class="p-4">
                            #{{ $campaign->id }}
                        </td>



                        <td class="p-4 font-medium">

                            {{ $campaign->title ?: 'بدون عنوان' }}

                        </td>



                        <td class="p-4">

                            <span class="px-2 py-1 text-xs rounded {{ $class }}">

                                {{ $statusLabel }}

                            </span>

                        </td>



                        <td class="p-4">

                            ${{ number_format($budget, 2) }}

                        </td>



                        <td class="p-4 text-red-600">

                            ${{ number_format($spent, 2) }}

                        </td>



                        <td class="p-4 text-green-600">

                            ${{ number_format($remaining, 2) }}

                        </td>



                        <td class="p-4">

                            {{ $usage }}%

                        </td>



                        <td class="p-4 text-xs text-gray-500">

                            {{ $campaign->created_at?->format('Y-m-d H:i') }}

                        </td>



                        <td class="p-4">

                            <div class="flex justify-end gap-4">


                                <a href="{{ route('admin.campaigns.show', $campaign->id) }}"
                                   class="text-blue-600 hover:underline">

                                    عرض

                                </a>


                                <a href="{{ route('admin.campaigns.review', $campaign->id) }}"
                                   class="text-green-600 hover:underline">

                                    مراجعة

                                </a>


                            </div>

                        </td>


                    </tr>


                @empty


                    <tr>

                        <td colspan="9"
                            class="text-center py-10 text-gray-500">

                            لا توجد حملات إعلانية حالياً

                        </td>

                    </tr>


                @endforelse


                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection