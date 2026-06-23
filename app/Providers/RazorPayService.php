<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\PaymentService;

class RazorPayService extends ServiceProvider
{
    /**
     * Register services.
     */
   public function register(): void
    {
        // Bind the service to the container
        $this->app->singleton(PaymentService::class, function ($app) {
            return new PaymentService(
                config('services.razorpay.key'),
                config('services.razorpay.secret')
            );
        });
    }

  
    public function boot(): void
    {
        
    }
}
