@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto space-y-6">

    <!-- HEADER -->
    <div>
        <h1 class="text-2xl font-bold">Account Settings</h1>
        <p class="text-gray-500">Manage your profile and security settings</p>
    </div>

    <!-- PROFILE INFO -->
    <div class="bg-white p-6 rounded shadow">

        <h2 class="text-lg font-semibold mb-4">Profile Information</h2>

        <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
            @csrf
            @method('PATCH')

            <!-- NAME -->
            <div>
                <label class="block text-sm text-gray-600">Name</label>
                <input type="text"
                       name="name"
                       value="{{ old('name', auth()->user()->name) }}"
                       class="w-full border rounded p-2">
            </div>

            <!-- EMAIL -->
            <div>
                <label class="block text-sm text-gray-600">Email</label>
                <input type="email"
                       name="email"
                       value="{{ old('email', auth()->user()->email) }}"
                       class="w-full border rounded p-2">
            </div>

            <button class="bg-blue-600 text-white px-4 py-2 rounded">
                Save Changes
            </button>

        </form>

    </div>

    <!-- PASSWORD -->
    <div class="bg-white p-6 rounded shadow">

        <h2 class="text-lg font-semibold mb-4">Change Password</h2>

        <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm text-gray-600">Current Password</label>
                <input type="password" name="current_password" class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block text-sm text-gray-600">New Password</label>
                <input type="password" name="password" class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block text-sm text-gray-600">Confirm Password</label>
                <input type="password" name="password_confirmation" class="w-full border rounded p-2">
            </div>

            <button class="bg-green-600 text-white px-4 py-2 rounded">
                Update Password
            </button>

        </form>

    </div>

    <!-- ACCOUNT DANGER ZONE -->
    <div class="bg-white p-6 rounded shadow border border-red-200">

        <h2 class="text-lg font-semibold text-red-600 mb-4">
            Danger Zone
        </h2>

        <p class="text-gray-600 mb-4">
            Once you delete your account, there is no going back.
        </p>

        <form method="POST" action="{{ route('profile.destroy') }}">
            @csrf
            @method('DELETE')

            <button class="bg-red-600 text-white px-4 py-2 rounded">
                Delete Account
            </button>

        </form>

    </div>

</div>

@endsection
