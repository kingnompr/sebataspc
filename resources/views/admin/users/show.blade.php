@extends('admin.layout')

@section('title', 'User Details')
@section('page-title', $user->name)
@section('page-description', 'User information and activity')

@section('content')
<div class="bg-surface-light dark:bg-surface-dark rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm p-6">
    <div class="flex items-center gap-4 mb-6">
        <div class="size-16 rounded-full bg-primary text-white flex items-center justify-center text-2xl font-bold">
            {{ strtoupper(substr($user->name, 0, 2)) }}
        </div>
        <div>
            <h3 class="text-xl font-bold text-slate-900 dark:text-white">{{ $user->name }}</h3>
            <p class="text-slate-500 dark:text-slate-400">{{ $user->email }}</p>
            @if($user->is_admin)
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 mt-2">
                    Admin
                </span>
            @endif
        </div>
    </div>
    
    <div class="grid grid-cols-3 gap-4 mb-6">
        <div>
            <p class="text-sm text-slate-500 dark:text-slate-400">Total Orders</p>
            <p class="text-2xl font-bold text-slate-900 dark:text-white">{{ $user->orders->count() }}</p>
        </div>
        <div>
            <p class="text-sm text-slate-500 dark:text-slate-400">Reviews</p>
            <p class="text-2xl font-bold text-slate-900 dark:text-white">{{ $user->reviews->count() }}</p>
        </div>
        <div>
            <p class="text-sm text-slate-500 dark:text-slate-400">Member Since</p>
            <p class="text-lg font-bold text-slate-900 dark:text-white">{{ $user->created_at->format('M Y') }}</p>
        </div>
    </div>
</div>
@endsection
