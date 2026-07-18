@extends('layouts.app')

@section('content')

<div class="p-6 space-y-6">

    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900">
            إدارة المستخدمين
        </h1>

        <a href="{{ route('admin.users.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700 transition">
            + إضافة مستخدم
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border overflow-x-auto">

        <table class="w-full text-sm">

            <thead class="bg-gray-50 border-b text-gray-600">
                <tr>
                    <th class="p-3 text-right">المعرف</th>
                    <th class="p-3 text-right">الاسم</th>
                    <th class="p-3 text-right">البريد الإلكتروني</th>
                    <th class="p-3 text-right">الدور</th>
                    <th class="p-3 text-left">الإجراءات</th>
                </tr>
            </thead>

            <tbody>

                @forelse($users ?? [] as $user)

                    <tr class="border-b hover:bg-gray-50">

                        <td class="p-3">{{ $user->id }}</td>

                        <td class="p-3 font-medium text-gray-900">
                            {{ $user->name }}
                        </td>

                        <td class="p-3 text-gray-600">
                            {{ $user->email }}
                        </td>

                        <td class="p-3">
                            <span class="text-xs px-2 py-1 rounded bg-gray-100 text-gray-700">
                                {{ $user->role }}
                            </span>
                        </td>

                        <td class="p-3">
                            <div class="flex gap-3 justify-end">

                                <a href="{{ route('admin.users.show', $user->id) }}"
                                   class="text-blue-600 hover:underline">
                                    عرض
                                </a>

                                <a href="{{ route('admin.users.edit', $user->id) }}"
                                   class="text-yellow-600 hover:underline">
                                    تعديل
                                </a>

                                <form method="POST"
                                      action="{{ route('admin.users.destroy', $user->id) }}"
                                      class="inline">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="text-red-600 hover:underline"
                                            onclick="return confirm('هل أنت متأكد من حذف هذا المستخدم؟')">
                                        حذف
                                    </button>

                                </form>

                            </div>
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="5" class="p-6 text-center text-gray-500">
                            لا يوجد مستخدمون حالياً
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection
