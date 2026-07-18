@extends('layouts.app')

@section('content')

<div class="p-6 space-y-6">

    <h1 class="text-2xl font-bold text-gray-900">
        إنشاء مستخدم جديد
    </h1>

    <div class="bg-white p-6 rounded-xl shadow-sm border">

        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf

            <div class="space-y-4">

                <div>
                    <label class="block text-sm text-gray-600 mb-1">الاسم</label>
                    <input type="text" name="name"
                           class="w-full border rounded-lg p-2 focus:outline-none focus:ring"
                           placeholder="أدخل اسم المستخدم">
                </div>

                <div>
                    <label class="block text-sm text-gray-600 mb-1">البريد الإلكتروني</label>
                    <input type="email" name="email"
                           class="w-full border rounded-lg p-2 focus:outline-none focus:ring"
                           placeholder="example@email.com">
                </div>

                <div>
                    <label class="block text-sm text-gray-600 mb-1">الدور</label>
                    <select name="role"
                            class="w-full border rounded-lg p-2 focus:outline-none focus:ring">

                        <option value="admin">مدير</option>
                        <option value="advertiser">معلن</option>
                        <option value="publisher">ناشر</option>

                    </select>
                </div>

                <div>
                    <label class="block text-sm text-gray-600 mb-1">كلمة المرور</label>
                    <input type="password" name="password"
                           class="w-full border rounded-lg p-2 focus:outline-none focus:ring"
                           placeholder="••••••••">
                </div>

                <div class="flex justify-end pt-2">

                    <button type="submit"
                            class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition">
                        إنشاء المستخدم
                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

@endsection
