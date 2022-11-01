<?php

namespace Jensramakers\LaravelMakeCrud;

use Illuminate\Support\ServiceProvider;
use Jensramakers\LaravelMakeCrud\app\Console\Commands\MakeCrud;

class LaravelMakeCrudServiceProvider extends ServiceProvider
{
    public function register()
    {
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeCrud::class,
                PublishCustomStubs::class,
            ]);
        }
    }
}
