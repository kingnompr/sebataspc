<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::withCount(['orders', 'reviews']);
        
        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        // Filter by role
        if ($request->filled('role')) {
            if ($request->role === 'admin') {
                $query->where('is_admin', true);
            } elseif ($request->role === 'customer') {
                $query->where('is_admin', false);
            }
        }
        
        $users = $query->latest()->paginate(20);
        
        $stats = [
            'total' => User::count(),
            'admins' => User::where('is_admin', true)->count(),
            'customers' => User::where('is_admin', false)->count(),
        ];
        
        return view('admin.users.index', compact('users', 'stats'));
    }
    
    public function show(User $user): View
    {
        $user->load(['orders', 'reviews.product']);
        
        return view('admin.users.show', compact('user'));
    }
    
    public function edit(User $user): View
    {
        return view('admin.users.edit', compact('user'));
    }
    
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'is_admin' => 'boolean',
        ]);
        
        $user->update($request->only(['name', 'email', 'is_admin']));
        
        return redirect()->route('admin.users.index')->with('success', 'User updated successfully');
    }
    
    public function destroy(User $user)
    {
        // Prevent deleting own account
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'You cannot delete your own account');
        }
        
        $user->delete();
        
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
    }
}
