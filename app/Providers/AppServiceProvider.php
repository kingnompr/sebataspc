<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Order;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS in production (Railway)
        if (config('app.env') === 'production') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        // Share pending orders count with admin layout
        View::composer('admin.layout', function ($view) {
            if (auth()->check() && auth()->user()->is_admin) {
                $stats = [
                    'pending_orders' => Order::whereIn('status', ['pending', 'processing'])->count(),
                ];
                $view->with('stats', $stats);
            }
        });
    }
}
