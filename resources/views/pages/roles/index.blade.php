@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Roles</h1>
                <p class="text-gray-600 dark:text-gray-400">Manage system roles and permissions</p>
            </div>
            <a href="{{ route('roles.create') }}"
                class="bg-brand-500 hover:bg-brand-600 rounded-lg px-6 py-3 text-white font-medium transition">
                + Create Role
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

        <div class="overflow-x-auto rounded-lg border border-gray-200 bg-white shadow dark:border-gray-800 dark:bg-gray-900">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">ID</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Name</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Created At</th>
                        <th class="px-6 py-3 text-right text-sm font-semibold text-gray-900 dark:text-white">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($roles as $role)
                        <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800">
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $role['id'] ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">{{ $role['name'] ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                {{ isset($role['created_at']) ? date('M d, Y', strtotime($role['created_at'])) : '-' }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('roles.edit', $role['id']) }}"
                                        class="text-brand-500 hover:text-brand-600 font-medium text-sm">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('roles.destroy', $role['id']) }}" class="inline"
                                        onsubmit="return confirm('Are you sure you want to delete this role?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-600 font-medium text-sm">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                No roles found. <a href="{{ route('roles.create') }}"
                                    class="text-brand-500 hover:text-brand-600 font-medium">Create one</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
