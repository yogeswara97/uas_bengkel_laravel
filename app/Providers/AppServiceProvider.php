<?php

namespace App\Providers;

use App\Models\Cart;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

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
        View::composer('*', function ($view) {
            $cartCount = 0;
            $user = Auth::guard('customer')->user();
            if ($user) {
                $cartCount = Cart::where('customer_id', $user->id)->count('quantity');
            }
            $view->with('cartCount', $cartCount);
        });
    }
}
