<?php

namespace App\Providers;

use App\Domain\Repos\ParticipantRepositoryInterface;
use App\Domain\Repos\TaskRepositoryInterface;
use App\Repos\ParticipantRepository;
use App\Repos\TaskRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() : void
    {
        $this->app->bind(TaskRepositoryInterface::class, TaskRepository::class);
        $this->app->bind(ParticipantRepositoryInterface::class, ParticipantRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
