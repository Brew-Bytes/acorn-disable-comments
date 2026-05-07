<?php

declare(strict_types=1);

namespace BrewAndBytes\AcornDisableComments;

use Illuminate\Support\ServiceProvider;

class DisableCommentsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/disable-comments.php', 'disable-comments');

        $this->app->singleton(
            DisableComments::class,
            fn ($app): DisableComments => DisableComments::make($app)
        );
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/disable-comments.php' => $this->app->configPath('disable-comments.php'),
        ], 'disable-comments-config');

        $this->app->make(DisableComments::class);
    }
}
