@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Users</h1>
                <p class="text-gray-600 dark:text-gray-400">Manage users and permissions</p>
            </div>
            <a href="{{ route('users.create') }}"
                class="bg-brand-500 hover:bg-brand-600 rounded-lg px-6 py-3 text-white font-medium transition">
                + Create User
            </a>
        </div>

        @if (session('success'))
            <div class="mb-6 rounded-lg border border-green-100 bg-green-50 p-4 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 rounded-lg border border-red-100 bg-red-50 p-4 text-red-700">
                {{ $errors->first() }}
            </div>
        @endif

        @php
            $colors = ['error', 'info'];
        @endphp

        <div class="overflow-x-auto rounded-lg border border-gray-200 bg-white shadow dark:border-gray-800 dark:bg-gray-900">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Name</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Username</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Status</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Role</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Date of Register</th>
                        <th class="px-6 py-3 text-right text-sm font-semibold text-gray-900 dark:text-white">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800">
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">
                                {{ $user['name'] ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">
                                {{ $user['username_tiktok'] ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">
                                @php
                                    $statusMap = [
                                        1 => ['label' => 'Active',   'color' => 'info'],
                                        2 => ['label' => 'Inactive', 'color' => 'error'],
                                    ];
                                $status = $statusMap[$user['status']] ?? ['label' => '-', 'class' => 'bg-gray-100 text-gray-500'];
                                @endphp

                                <x-ui.badge :color="$status['color']" variant="solid">
                                    {{ $status['label'] }}
                                </x-ui.badge>
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">
                                {{ $user['role']['name'] ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">
                                {{ isset($user['created_at']) ? date('M d, Y', strtotime($user['created_at'])) : '-' }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('users.edit', $user['id']) }}"
                                        class="text-brand-500 hover:text-brand-600 font-medium text-sm">
                                        Edit
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                No user found. <a href="{{ route('users.create') }}"
                                    class="text-brand-500 hover:text-brand-600 font-medium">Add one!</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
