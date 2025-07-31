<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\CalculatorSettingRepositoryInterface;
use App\Repositories\CalculatorSettingRepositories;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            CalculatorSettingRepositoryInterface::class,
            CalculatorSettingRepositories::class
        );
    }

    public function boot(): void
    {
        //
    }
}

