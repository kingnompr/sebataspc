<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AccountController extends Controller
{
    /**
     * Show the primary account overview.
     */
    public function overview(Request $request): View
    {
        $user = $this->resolveUser($request->user());

        $user->load([
            'addresses' => fn ($query) => $query->orderByDesc('is_default'),
            'orders.items.product',
            'savedBuilds.pcBuild.components.product',
        ]);

        // Check if user is searching for specific order by ID
        $orderIdSearch = $request->input('order_id');
        
        if ($orderIdSearch) {
            // Search for order by order_number
            $activeOrder = $user->orders()
                ->where('order_number', 'LIKE', '%' . $orderIdSearch . '%')
                ->with('items.product')
                ->latest('created_at')
                ->first();
        } else {
            // Get latest active order
            $activeOrder = $user->orders()
                ->active()
                ->with('items.product')
                ->latest('created_at')
                ->first();
        }

        $orderHistory = $user->orders()
            ->latest('created_at')
            ->get();

        $savedBuilds = $user->savedBuilds()
            ->with('pcBuild.components.product')
            ->latest('updated_at')
            ->take(3)
            ->get();

        $defaultAddress = $user->addresses->firstWhere('is_default', true)
            ?? $user->addresses->first();

        $totalSpend = $user->orders()->sum('total');
        $yearlySpend = $user->orders()
            ->whereYear('created_at', now()->year)
            ->sum('total');
        $points = (int) round($totalSpend / 1000);

        $tierLabel = match (true) {
            $points >= 20_000 => 'Member Platinum',
            $points >= 10_000 => 'Member Gold',
            $points >= 5_000 => 'Member Silver',
            default => 'Member Bronze',
        };

        $loyalty = [
            'points' => $points,
            'nextTier' => 'Echelon Diamond',
            'nextTierPoints' => max(0, 20_000 - $points),
            'spendThisYear' => $yearlySpend,
        ];

        $avatarUrl = 'https://www.gravatar.com/avatar/'.md5(strtolower(trim($user->email))).'?s=160&d=identicon';

        return view('account.overview', [
            'user' => $user,
            'activeOrder' => $activeOrder,
            'orderHistory' => $orderHistory,
            'savedBuilds' => $savedBuilds,
            'defaultAddress' => $defaultAddress,
            'loyalty' => $loyalty,
            'tierLabel' => $tierLabel,
            'avatarUrl' => $avatarUrl,
        ]);
    }
    /**
     * Manage stored payment methods.
     */
    public function payments(Request $request): View
    {
        $user = $this->resolveUser($request->user());

        // Get orders pending payment
        $pendingOrders = $user->orders()
            ->whereIn('status', ['pending'])
            ->with('items.product')
            ->latest('created_at')
            ->get();

        // Get paid/completed orders
        $paidOrders = $user->orders()
            ->whereIn('status', ['paid', 'processing', 'shipped', 'delivered'])
            ->with('items.product')
            ->latest('created_at')
            ->get();

        return view('account.payments', compact('user', 'pendingOrders', 'paidOrders'));
    }

    /**
     * Display saved addresses.
     */
    public function addresses(Request $request): View
    {
        $user = $this->resolveUser($request->user());
        $addresses = $user->addresses()->latest()->get();

        return view('account.addresses', compact('user', 'addresses'));
    }

    /**
     * Show edit profile form.
     */
    public function edit(Request $request): View
    {
        $user = $this->resolveUser($request->user());
        
        return view('account.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update user profile.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $this->resolveUser($request->user());

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'profile_photo' => ['nullable', 'image', 'max:2048'], // 2MB max
            'current_password' => ['nullable', 'required_with:password', 'string'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        // Update name
        $user->name = $data['name'];

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $user->profile_photo_path = $path;
        }

        // Handle password change
        if ($request->filled('password')) {
            if (!Hash::check($data['current_password'], $user->password)) {
                return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.'])->withInput();
            }
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        return redirect()->route('account.overview')->with('status', 'Profil berhasil diperbarui!');
    }

    /**
     * Store new address.
     */
    public function storeAddress(Request $request): RedirectResponse
    {
        $user = $this->resolveUser($request->user());

        $data = $request->validate([
            'label' => ['required', 'string', 'max:255'],
            'recipient' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'line_one' => ['required', 'string', 'max:500'],
            'line_two' => ['nullable', 'string', 'max:500'],
            'city' => ['required', 'string', 'max:255'],
            'province' => ['required', 'string', 'max:255'],
            'postal_code' => ['required', 'string', 'max:10'],
            'is_default' => ['nullable', 'boolean'],
        ]);

        // If this is set as default, unset all other defaults
        if ($request->boolean('is_default')) {
            $user->addresses()->update(['is_default' => false]);
            $data['is_default'] = true;
        } else {
            $data['is_default'] = false;
        }

        $user->addresses()->create($data);

        return redirect()->route('account.addresses')->with('status', 'Alamat berhasil ditambahkan!');
    }

    /**
     * Render invoice page for a specific order.
     */
    public function orderInvoice(Request $request, Order $order): View
    {
        $user = $this->resolveUser($request->user());

        abort_if($order->user_id !== $user->id, 403, 'Anda tidak memiliki akses ke invoice ini.');

        $order->loadMissing('items.product');
        $address = $user->addresses()->where('is_default', true)->first();

        return view('account.invoice', [
            'user' => $user,
            'order' => $order,
            'address' => $address,
        ]);
    }

    protected function resolveUser(?User $user): User
    {
        abort_unless($user, 401, 'Silakan login untuk mengakses halaman akun.');

        return $user;
    }
}
