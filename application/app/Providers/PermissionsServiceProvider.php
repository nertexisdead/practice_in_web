<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class PermissionsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('permission', function (...$permissions) {
            $str = implode(', ', $permissions);
            return "<?php if(auth()->check() && auth()->user()->hasPermission({$str})): ?>";
        });

        Blade::directive('endpermission', function (...$permissions) {
            return "<?php endif; ?>";
        });
    }
}
