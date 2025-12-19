@extends('admin.layout')

@section('title', 'Users Management')
@section('page-title', 'Users Management')
@section('page-description', 'Manage registered users')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    <div class="bg-surface-light dark:bg-surface-dark p-5 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm">
        <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">Total Users</p>
        <h3 class="text-2xl font-bold text-slate-900 dark:text-white mt-1">{{ $stats['total'] }}</h3>
    </div>
    <div class="bg-surface-light dark:bg-surface-dark p-5 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm">
        <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">Admins</p>
        <h3 class="text-2xl font-bold text-slate-900 dark:text-white mt-1">{{ $stats['admins'] }}</h3>
    </div>
    <div class="bg-surface-light dark:bg-surface-dark p-5 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm">
        <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">Customers</p>
        <h3 class="text-2xl font-bold text-slate-900 dark:text-white mt-1">{{ $stats['customers'] }}</h3>
    </div>
</div>

<!-- Users Table -->
<div class="bg-surface-light dark:bg-surface-dark rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 dark:bg-gray-800/50 text-xs text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                    <th class="px-6 py-4 font-semibold">Name</th>
                    <th class="px-6 py-4 font-semibold">Email</th>
                    <th class="px-6 py-4 font-semibold">Role</th>
                    <th class="px-6 py-4 font-semibold">Orders</th>
                    <th class="px-6 py-4 font-semibold">Joined</th>
                    <th class="px-6 py-4 font-semibold text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800 text-sm">
                @forelse($users as $user)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="size-8 rounded-full bg-primary text-white flex items-center justify-center text-xs font-bold">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                                <span class="font-medium text-slate-900 dark:text-white">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-600 dark:text-slate-300">{{ $user->email }}</td>
                        <td class="px-6 py-4">
                            @if($user->is_admin)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400">
                                    Admin
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                    Customer
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-slate-600 dark:text-slate-300">{{ $user->orders_count }}</td>
                        <td class="px-6 py-4 text-slate-500">{{ $user->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.users.show', $user) }}" class="text-primary hover:text-primary-hover">
                                <span class="material-symbols-outlined">visibility</span>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <p class="text-sm text-slate-500 dark:text-slate-400">No users found.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($users->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-800">
            {{ $users->links() }}
        </div>
    @endif
</div>
@endsection
