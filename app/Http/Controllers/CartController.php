<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CartController extends Controller
{
    /**
     * Display the active cart.
     */
    public function index(Request $request): View
    {
        $cart = $this->resolveCart($request)->loadMissing('items.product');
        $recommended = Product::inStock()
            ->where('is_recommended', true)
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('cart.index', compact('cart', 'recommended'));
    }

    /**
     * Show the checkout page.
     */
    public function checkout(Request $request): View
    {
        $cart = $this->resolveCart($request)->loadMissing('items.product');

        $subtotal = $cart->items->sum(function ($item) {
            $price = optional($item->product)->price ?? 0;

            return $price * ($item->quantity ?? 0);
        });

        $shippingFee = 50_000;
        $insuranceFee = (int) round($subtotal * 0.002);
        $discount = 0;
        $total = $subtotal + $shippingFee + $insuranceFee - $discount;

        $shippingOptions = [
            [
                'id' => 'jne-regular',
                'label' => 'JNE Reguler (Asuransi Wajib)',
                'description' => 'Estimasi tiba: 2-3 hari',
                'price' => 50_000,
                'badge' => 'Rekomendasi',
            ],
            [
                'id' => 'jne-yes',
                'label' => 'JNE YES (Yakin Esok Sampai)',
                'description' => 'Estimasi tiba: 1 hari',
                'price' => 85_000,
            ],
            [
                'id' => 'gosend',
                'label' => 'GoSend Instant (Kurir Motor)',
                'description' => 'Tiba hari ini (Max jam 18.00)',
                'price' => 120_000,
            ],
        ];

        $prefill = [
            'first_name' => 'Budi',
            'last_name' => 'Santoso',
            'address' => 'Jl. Jendral Sudirman No. 45, Kav 10',
            'city' => 'Jakarta Pusat',
            'postal_code' => '10220',
            'phone' => '+62 81234567890',
        ];

        return view('cart.checkout', [
            'cart' => $cart,
            'shippingOptions' => $shippingOptions,
            'selectedShippingId' => $shippingOptions[0]['id'] ?? null,
            'prefill' => $prefill,
            'summary' => [
                'subtotal' => $subtotal,
                'shipping' => $shippingFee,
                'insurance' => $insuranceFee,
                'discount' => $discount,
                'total' => $total,
            ],
        ]);
    }

    /**
     * Process checkout form and store data in session.
     */
    public function processCheckout(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:500'],
            'city' => ['required', 'string', 'max:255'],
            'postal_code' => ['required', 'string', 'max:10'],
            'phone' => ['required', 'string', 'max:20'],
            'shipping_method' => ['required', 'string'],
            'payment_method' => ['required', 'string', 'in:cod,bank_mandiri,bank_bca,bank_bri,dana,gopay'],
        ]);

        // Store checkout data in session
        session([
            'checkout_data' => $data,
        ]);

        return redirect()->route('checkout.payment');
    }

    /**
     * Show payment page based on payment method.
     */
    public function payment(Request $request): View
    {
        $checkoutData = session('checkout_data');
        
        if (!$checkoutData) {
            return redirect()->route('checkout.show');
        }

        $cart = $this->resolveCart($request)->loadMissing('items.product');
        
        $subtotal = $cart->items->sum(function ($item) {
            $price = optional($item->product)->price ?? 0;
            return $price * ($item->quantity ?? 0);
        });

        $shippingFee = 50_000;
        $insuranceFee = (int) round($subtotal * 0.002);
        $discount = 0;
        $total = $subtotal + $shippingFee + $insuranceFee - $discount;

        // Generate Virtual Account for bank transfers
        $virtualAccount = null;
        if (in_array($checkoutData['payment_method'], ['bank_mandiri', 'bank_bca', 'bank_bri'])) {
            $bankCode = match($checkoutData['payment_method']) {
                'bank_mandiri' => '008',
                'bank_bca' => '014',
                'bank_bri' => '002',
            };
            $virtualAccount = $bankCode . rand(1000000000, 9999999999);
        }

        $orderNumber = 'ORD-'.now()->format('Ymd').'-'.Str::upper(Str::random(4));

        return view('cart.payment', [
            'checkoutData' => $checkoutData,
            'cart' => $cart,
            'orderNumber' => $orderNumber,
            'virtualAccount' => $virtualAccount,
            'summary' => [
                'subtotal' => $subtotal,
                'shipping' => $shippingFee,
                'insurance' => $insuranceFee,
                'discount' => $discount,
                'total' => $total,
            ],
        ]);
    }

    /**
     * Show order confirmation/thank you page.
     */
    public function confirmation(Request $request): View
    {
        $cart = $this->resolveCart($request)->loadMissing('items.product');

        $orderNumber = 'PC-'.now()->format('Ymd').'-'.Str::upper(Str::random(4));
        $items = $cart->items;

        $subtotal = $items->sum(function ($item) {
            $price = optional($item->product)->price ?? 0;

            return $price * ($item->quantity ?? 0);
        });

        $shippingFee = 150_000;
        $discount = 200_000;
        $total = $subtotal + $shippingFee - $discount;

        $trackingTimeline = [
            [
                'label' => 'Pesanan Diterima',
                'time' => now()->format('d M Y, H:i').' WIB',
                'status' => 'done',
            ],
            [
                'label' => 'Pembayaran Berhasil',
                'time' => now()->addMinutes(5)->format('d M Y, H:i').' WIB',
                'status' => 'done',
            ],
            [
                'label' => 'Sedang Diproses',
                'time' => 'Tim kami sedang menyiapkan komponen Anda.',
                'status' => 'active',
            ],
            [
                'label' => 'Estimasi Pengiriman',
                'time' => now()->addDays(2)->format('d M').' - '.now()->addDays(4)->format('d M Y'),
                'status' => 'pending',
            ],
        ];

        $shippingAddress = [
            'recipient' => 'John Doe (Rumah)',
            'address' => 'Jalan Jendral Sudirman No. 45, RT.01/RW.03, Menteng, Jakarta Pusat, DKI Jakarta, 10220',
            'phone' => '0812-3456-7890',
            'city' => 'Jakarta Pusat, DKI Jakarta',
        ];

        $paymentSummary = [
            'method' => 'Transfer Bank BCA',
            'status' => 'Lunas',
        ];

        return view('cart.confirmation', [
            'cart' => $cart,
            'orderNumber' => $orderNumber,
            'trackingTimeline' => $trackingTimeline,
            'summary' => [
                'subtotal' => $subtotal,
                'shipping' => $shippingFee,
                'discount' => $discount,
                'total' => $total,
            ],
            'shippingAddress' => $shippingAddress,
            'paymentSummary' => $paymentSummary,
        ]);
    }


    /**
     * Add an item to the cart or increment its quantity.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $product = Product::findOrFail($data['product_id']);

        $cart = $this->resolveCart($request);
        $currentQuantity = $cart->items()->where('product_id', $product->id)->value('quantity') ?? 0;

        if ($product->stock < $currentQuantity + $data['quantity']) {
            return back()->withErrors([
                'quantity' => 'Stok produk tidak mencukupi untuk jumlah yang dipilih.',
            ])->withInput();
        }

        DB::transaction(function () use ($cart, $product, $data) {
            $item = $cart->items()->firstOrNew(['product_id' => $product->id]);
            $item->quantity = ($item->exists ? $item->quantity : 0) + $data['quantity'];
            $item->save();
        });

        return back()->with('status', 'Produk berhasil ditambahkan ke keranjang.');
    }

    /**
     * Update the quantity of a cart item.
     */
    public function update(Request $request, CartItem $cartItem): RedirectResponse
    {
        $cart = $this->resolveCart($request);
        $this->authorizeCartItem($cartItem, $cart);

        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        if ($cartItem->product->stock < $data['quantity']) {
            return back()->withErrors([
                'quantity' => 'Stok produk tidak mencukupi untuk jumlah yang dipilih.',
            ])->withInput();
        }

        $cartItem->update(['quantity' => $data['quantity']]);

        return redirect()
            ->route('cart.index')
            ->with('status', 'Jumlah item berhasil diperbarui.');
    }

    /**
     * Remove a cart item.
     */
    public function destroy(Request $request, CartItem $cartItem): RedirectResponse
    {
        $cart = $this->resolveCart($request);
        $this->authorizeCartItem($cartItem, $cart);

        $cartItem->delete();

        return redirect()
            ->route('cart.index')
            ->with('status', 'Produk dihapus dari keranjang.');
    }

    /**
     * Clear every item in the user's cart.
     */
    public function clear(Request $request): RedirectResponse
    {
        $cart = $this->resolveCart($request);
        $cart->items()->delete();

        return redirect()
            ->route('cart.index')
            ->with('status', 'Keranjang berhasil dikosongkan.');
    }

    /**
     * Resolve the current cart for the authenticated user or session.
     */
    protected function resolveCart(Request $request): Cart
    {
        if ($request->user()) {
            return Cart::firstOrCreate(
                ['user_id' => $request->user()->id],
                ['session_id' => $request->session()->getId()]
            );
        }

        return Cart::firstOrCreate(['session_id' => $request->session()->getId()]);
    }

    /**
     * Ensure the cart item belongs to the active cart.
     */
    protected function authorizeCartItem(CartItem $cartItem, Cart $cart): void
    {
        abort_unless($cartItem->cart_id === $cart->id, 403, 'Item tidak ditemukan dalam keranjang Anda.');
    }
}
