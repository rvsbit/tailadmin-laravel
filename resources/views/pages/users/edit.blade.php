@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">
            <div class="mb-8">
                <a href="{{ route('users.index') }}"
                    class="inline-flex items-center text-sm text-gray-500 transition-colors hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                    <svg class="stroke-current mr-2" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                        viewBox="0 0 20 20" fill="none">
                        <path d="M12.7083 5L7.5 10.2083L12.7083 15.4167" stroke="" stroke-width="1.5"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Back to User
                </a>
            </div>

            <div class="rounded-lg border border-gray-200 bg-white p-8 shadow dark:border-gray-800 dark:bg-gray-900">
                <h1 class="mb-2 text-3xl font-bold text-gray-900 dark:text-white">Edit user</h1>
                <p class="mb-8 text-gray-600 dark:text-gray-400">Update user information</p>

                @if ($errors->any())
                    <div class="mb-6 rounded-lg border border-red-100 bg-red-50 p-4 text-red-700">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('users.update', $users['id']) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <? // name ?>
                    <div>
                        <label for="name" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                            Name<span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="name" name="name" placeholder="e.g., Alice Doe"
                            value="{{ old('name', $users['name'] ?? '') }}" required
                            class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 placeholder-gray-400 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:placeholder-gray-500" />
                        @error('name')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <? // email ?>
                    <div>
                        <label for="email" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                            Email<span class="text-red-500">*</span>
                        </label>
                        <input type="email" id="email" name="email" placeholder="e.g., Alice Doe"
                            value="{{ old('email', $users['email'] ?? '') }}" required
                            class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 placeholder-gray-400 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:placeholder-gray-500" />
                        @error('email')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                     <? // phone ?>
                    <div>
                        <label for="phone" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                            Phone<span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="phone" name="phone" placeholder="e.g., 0123456789"
                            value="{{ old('phone', $users['phone'] ?? '') }}" required
                            class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 placeholder-gray-400 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:placeholder-gray-500" />
                        @error('phone')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <? // username ?>
                    <div>
                        <label for="username_tiktok" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                            Username<span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="username_tiktok" name="username_tiktok" placeholder="e.g., @rvsb"
                            value="{{ old('username_tiktok', $users['username_tiktok'] ?? '') }}" required
                            class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 placeholder-gray-400 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:placeholder-gray-500" />
                        @error('username_tiktok')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <? // role ?>
                    <div>
                        <label for="role_id" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                            Role<span class="text-red-500">*</span>
                        </label>
                        <select name="role_id" id="role_id"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm
                            text-gray-800 bg-white focus:outline-none focus:ring-2
                            focus:ring-indigo-500 focus:border-transparent
                            @error('role_id') border-red-400 @enderror">

                            <option value="">— Select Role —</option>

                            @forelse ($roles as $role)
                                <option value="{{ $role['id'] }}"
                                    {{ 
                                        old('role_id', $users['role_id'] ?? '') == $role['id'] 
                                        ? 'selected' 
                                        : '' 
                                    }}>
                                    {{ $role['name'] }}
                                </option>
                            @empty
                                <option disabled>No role found</option>
                            @endforelse
                        </select>
                        
                        @error('name')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <? // status ?>
                    <div>
                        <label for="status" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                            Status<span class="text-red-500">*</span>
                        </label>
                        @php
                            $statuses = [
                                1 => 'Active',
                                2 => 'Inactive',
                            ];
                        @endphp

                        <select name="status" id="status"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm
                                text-gray-800 bg-white focus:outline-none focus:ring-2
                                focus:ring-indigo-500 focus:border-transparent
                                @error('status') border-red-400 @enderror">

                            <option value="">— Select Status —</option>

                            @foreach ($statuses as $value => $label)
                                <option value="{{ $value }}"
                                    {{ old('status', $user['status'] ?? '') == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach

                        </select>

                        @error('status')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                        
                        @error('name')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>


                    <? // buttons ?>
                    <div class="flex gap-3 pt-4">
                        <button type="submit"
                            class="bg-brand-500 hover:bg-brand-600 rounded-lg px-6 py-2.5 text-white font-medium transition">
                            Update User
                        </button>
                        <a href="{{ route('users.index') }}"
                            class="rounded-lg border border-gray-300 bg-white px-6 py-2.5 text-gray-900 font-medium transition hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
