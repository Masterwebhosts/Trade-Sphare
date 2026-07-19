@extends('layouts.publisher')

@section('title', 'تفاصيل المنطقة الإعلانية')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">تفاصيل المنطقة الإعلانية</h3>

        <a href="{{ route('publisher.zones.edit', $zone->id) }}"
   class="btn btn-warning">
    تعديل
</a>

            <a href="{{ route('publisher.zones.index') }}"
               class="btn btn-secondary">
                رجوع
            </a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <table class="table table-bordered align-middle">

                <tr>
                    <th width="220">الاسم</th>
                    <td>{{ $zone->name }}</td>
                </tr>

                <tr>
                    <th>النوع</th>
                    <td>
                        @switch($zone->zone_type)
                            @case('banner')
                                بانر
                                @break

                            @case('native')
                                إعلان مدمج
                                @break

                            @case('popup')
                                نافذة منبثقة
                                @break

                            @default
                                {{ $zone->zone_type }}
                        @endswitch
                    </td>
                </tr>

                <tr>
                    <th>المحافظة</th>
                    <td>
                        {{ $zone->governorate?->name ?? 'جميع المحافظات' }}
                    </td>
                </tr>

                <tr>
                    <th>الحالة</th>
                    <td>
                        @if($zone->status == \App\Models\AdZone::STATUS_ACTIVE)
                            <span class="badge bg-success">
                                نشطة
                            </span>
                        @else
                            <span class="badge bg-danger">
                                غير نشطة
                            </span>
                        @endif
                    </td>
                </tr>

                <tr>
                    <th>رمز المنطقة (Token)</th>
                    <td>
                        <code>{{ $zone->token }}</code>
                    </td>
                </tr>

                <tr>
                    <th>تاريخ الإنشاء</th>
                    <td>{{ $zone->created_at?->format('Y-m-d H:i') ?? '-' }}</td>
                </tr>

            </table>

        </div>
    </div>

    <div class="card shadow-sm mt-4">
        <div class="card-header">
            <strong>الإعلانات المرتبطة</strong>
        </div>

        <div class="card-body">

            @if($zone->ads->isEmpty())

                <div class="alert alert-info mb-0">
                    لا توجد إعلانات مرتبطة بهذه المنطقة.
                </div>

            @else

                <table class="table table-striped">

                    <thead>
                    <tr>
                        <th>#</th>
                        <th>العنوان</th>
                        <th>النوع</th>
                        <th>الحالة</th>
                    </tr>
                    </thead>

                    <tbody>

                    @foreach($zone->ads as $ad)

                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>{{ $ad->title }}</td>

                            <td>{{ ucfirst($ad->type) }}</td>

                            <td>
                                @if($ad->status == \App\Models\Ad::STATUS_ACTIVE)
                                    <span class="badge bg-success">
                                        نشط
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        غير نشط
                                    </span>
                                @endif
                            </td>

                        </tr>

                    @endforeach

                    </tbody>

                </table>

            @endif

        </div>
    </div>

</div>
@endsection