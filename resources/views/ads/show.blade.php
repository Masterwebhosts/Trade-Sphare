@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto p-6 space-y-6">
        <div class="bg-white border rounded-xl shadow-sm p-6 space-y-4">
            <div>
                <h1 class="text-2xl font-bold">{{ $ad->title }}</h1>
                <p class="text-sm text-gray-500 mt-1">معاينة الإعلان #{{ $ad->id }}</p>
            </div>

            @if($ad->media_url)
                <div class="overflow-hidden rounded-lg border bg-gray-50">
                    <img src="{{ $ad->media_url }}" alt="{{ $ad->title }}" class="w-full object-cover">
                </div>
            @endif

            @if($ad->description)
                <p class="text-gray-700 leading-7">{{ $ad->description }}</p>
            @endif

            <div class="flex items-center justify-between gap-3 text-sm text-gray-500">
                <span>الحالة: {{ $ad->status }}</span>
                <a href="{{ $ad->target_url }}" target="_blank" rel="noopener" class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2 font-semibold text-white hover:bg-blue-700">
                    فتح رابط الإعلان
                </a>
            </div>
        </div>
    </div>
@endsection
