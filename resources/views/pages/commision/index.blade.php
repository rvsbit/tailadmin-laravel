@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Commision Rate</h1>
                <p class="text-gray-600 dark:text-gray-400">Manage commision rate and permissions</p>
            </div>
            <a href="{{ route('commision.create') }}"
                class="bg-brand-500 hover:bg-brand-600 rounded-lg px-6 py-3 text-white font-medium transition">
                + Create Rate
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
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Level</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Percent</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Created At</th>
                        <th class="px-6 py-3 text-right text-sm font-semibold text-gray-900 dark:text-white">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($rates as $rate)
                        <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">
                                {{ $rate['level'] ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">
                                {{ $rate['rate'] ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                {{ isset($rate['created_at']) ? date('M d, Y', strtotime($rate['created_at'])) : '-' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('commision.edit', $rate['id']) }}"
                                        class="text-brand-500 hover:text-brand-600 font-medium text-sm">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('commision.destroy', $rate['id']) }}" class="inline"
                                        onsubmit="return confirm('Are you sure you want to delete this rate?');">
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
                                No rate found. <a href="{{ route('commision.create') }}"
                                    class="text-brand-500 hover:text-brand-600 font-medium">Add one!</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
