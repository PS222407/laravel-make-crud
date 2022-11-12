<?php

namespace Jensramakers\LaravelMakeCrud;

use Illuminate\Support\ServiceProvider;
use Jensramakers\LaravelMakeCrud\app\Console\Commands\AssignRole;
use Jensramakers\LaravelMakeCrud\app\Console\Commands\MakeClass;
use Jensramakers\LaravelMakeCrud\app\Console\Commands\MakeCrud;
use Jensramakers\LaravelMakeCrud\app\Console\Commands\MakeEnum;
use Jensramakers\LaravelMakeCrud\app\Console\Commands\MakeTrait;

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
                AssignRole::class,
                MakeClass::class,
                MakeEnum::class,
                MakeTrait::class,
                PublishCustomStubs::class,
            ]);
        }
    }
}
