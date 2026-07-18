@extends('layouts.app')

@section('content')

<div class="p-6 space-y-6">

    <h1 class="text-2xl font-bold text-gray-900">
        تعديل بيانات المستخدم
    </h1>

    <div class="bg-white p-6 rounded-xl shadow-sm border">

        <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
            @csrf
            @method('PUT')

            <div class="space-y-4">

                <div>
                    <label class="block text-sm text-gray-600 mb-1">الاسم</label>
                    <input type="text" name="name"
                           value="{{ $user->name }}"
                           class="w-full border rounded-lg p-2 focus:outline-none focus:ring">
                </div>

                <div>
                    <label class="block text-sm text-gray-600 mb-1">البريد الإلكتروني</label>
                    <input type="email" name="email"
                           value="{{ $user->email }}"
                           class="w-full border rounded-lg p-2 focus:outline-none focus:ring">
                </div>

                <div>
                    <label class="block text-sm text-gray-600 mb-1">الدور</label>
                    <select name="role"
                            class="w-full border rounded-lg p-2 focus:outline-none focus:ring">

                        <option value="admin" @selected($user->role=='admin')>مدير</option>
                        <option value="advertiser" @selected($user->role=='advertiser')>معلن</option>
                        <option value="publisher" @selected($user->role=='publisher')>ناشر</option>

                    </select>
                </div>

                <div class="flex justify-end pt-2">

                    <button type="submit"
                            class="bg-yellow-500 text-white px-5 py-2 rounded-lg hover:bg-yellow-600 transition">
                        تحديث البيانات
                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

@endsection
