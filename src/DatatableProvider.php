<?php

namespace Slingmont\Datatable;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class DatatableProvider extends ServiceProvider {

    public function boot() {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/Resources/views', 'datatable');

        $this->publishes([
            __DIR__.'/Resources/assets/css' => public_path('vendor/slingmont_datatable-package/css'),
        ], 'public');
    }

    public function register()
    {

    }
}
