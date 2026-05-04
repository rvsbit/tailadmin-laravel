@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">
            <div class="mb-8">
                <a href="{{ route('sales.index') }}"
                    class="inline-flex items-center text-sm text-gray-500 transition-colors hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                    <svg class="stroke-current mr-2" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                        viewBox="0 0 20 20" fill="none">
                        <path d="M12.7083 5L7.5 10.2083L12.7083 15.4167" stroke="" stroke-width="1.5"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Back to Sales
                </a>
            </div>

            <div class="rounded-lg border border-gray-200 bg-white p-8 shadow dark:border-gray-800 dark:bg-gray-900">
                <h1 class="mb-2 text-3xl font-bold text-gray-900 dark:text-white">Edit sale</h1>
                <p class="mb-8 text-gray-600 dark:text-gray-400">Update sale information</p>

                @if ($errors->any())
                    <div class="mb-6 rounded-lg border border-red-100 bg-red-50 p-4 text-red-700">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('sales.update', $sales['id']) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <? // manager name ?>
                    <div>
                        <label for="manager_id" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                            Manager Name<span class="text-red-500">*</span>
                        </label>
                        <select name="manager_id" id="manager_id"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm
                            text-gray-800 bg-white focus:outline-none focus:ring-2
                            focus:ring-indigo-500 focus:border-transparent
                            @error('manager_id') border-red-400 @enderror">

                            <option value="">— Select Manager —</option>

                            @forelse ($managers as $manager)
                                <option value="{{ $manager['id'] }}"
                                    {{ 
                                        old('manager_id', $sales['manager_id'] ?? '') == $manager['id'] 
                                        ? 'selected' 
                                        : '' 
                                    }}>
                                    {{ $manager['name'] }}
                                </option>
                            @empty
                                <option disabled>No managers found</option>
                            @endforelse
                        </select>
                        
                        @error('name')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <? // amount ?>
                    <div>
                        <label for="amount" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                            Total Sale<span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="amount" name="amount" placeholder="e.g., John Doe"
                            value="{{ old('amount', $sales['amount'] ?? '') }}" required
                            class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 placeholder-gray-400 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:placeholder-gray-500" />
                        @error('name')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <? // date of sale ?>
                    <div>
                        <label for="sales_date" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                            Date of sale<span class="text-red-500">*</span>
                        </label>
                         <x-form.date-picker 
                            id="sales_date" 
                            name="sales_date"
                            placeholder="Date of sale" 
                            defaultDate="{{ now()->format('Y-m-d') }}" 
                            value="{{ old('sales_date', $sales['sales_date'] ?? '') }}"
                        />
                        @error('name')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <? // buttons ?>
                    <div class="flex gap-3 pt-4">
                        <button type="submit"
                            class="bg-brand-500 hover:bg-brand-600 rounded-lg px-6 py-2.5 text-white font-medium transition">
                            Update Sale
                        </button>
                        <a href="{{ route('sales.index') }}"
                            class="rounded-lg border border-gray-300 bg-white px-6 py-2.5 text-gray-900 font-medium transition hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
