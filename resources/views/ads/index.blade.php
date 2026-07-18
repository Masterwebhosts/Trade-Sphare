@extends('admin.layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-4">Ads</h1>

<div class="bg-white p-4 rounded shadow">

    @forelse($ads as $ad)
        <div class="border-b py-3 flex justify-between items-center">

            <div>
                <div class="font-semibold">
                    {{ $ad->title ?? 'Ad' }}
                </div>

                <div class="text-sm text-gray-500">
                    Campaign: {{ $ad->campaign->name ?? 'N/A' }}
                </div>

                <div class="text-sm text-gray-500">
                    Status: 
                    <span class="{{ $ad->status === 'active' ? 'text-green-600' : 'text-red-600' }}">
                        {{ $ad->status }}
                    </span>
                </div>
            </div>

            <div class="text-sm text-gray-400">
                ID: {{ $ad->id }}
            </div>

        </div>
    @empty
        <div class="text-gray-500">
            No ads found.
        </div>
    @endforelse

</div>

@endsection
