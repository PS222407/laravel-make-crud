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
        $this->loadRoutesFrom(base_path().'/routes/crud.php');

        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeCrud::class,
                PublishCustomStubs::class,
            ]);
        }
    }
}
