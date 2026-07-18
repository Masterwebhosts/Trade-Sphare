@extends('layouts.app')

@section('content')

<div class="p-6 space-y-6">

    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900">
            تفاصيل المستخدم
        </h1>

        <a href="{{ route('admin.users.index') }}"
           class="text-blue-600 text-sm hover:underline">
            ← رجوع
        </a>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border space-y-3">

        <div><b>المعرف:</b> {{ $user->id }}</div>
        <div><b>الاسم:</b> {{ $user->name }}</div>
        <div><b>البريد الإلكتروني:</b> {{ $user->email }}</div>
        <div><b>الدور:</b> {{ $user->role }}</div>
        <div><b>الرصيد:</b> {{ $user->wallet?->balance ?? 0 }}</div>

    </div>

</div>

@endsection
