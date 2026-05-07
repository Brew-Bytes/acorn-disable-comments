<?php

declare(strict_types=1);

namespace BrewAndBytes\AcornDisableComments;

use BrewAndBytes\AcornDisableComments\Concerns\HasCollection;
use Illuminate\Support\Collection;
use Roots\Acorn\Application;

/**
 * @phpstan-consistent-constructor
 */
class DisableComments
{
    use HasCollection;

    protected Application $app;

    protected Collection $config;

    /**
     * @var array<int, class-string<Modules\AbstractModule>>
     */
    protected array $modules = [
        Modules\CloseCommentsModule::class,
        Modules\HideExistingCommentsModule::class,
        Modules\AdminUiModule::class,
        Modules\FrontEndModule::class,
        Modules\RestApiModule::class,
        Modules\FeedsModule::class,
        Modules\XmlRpcModule::class,
    ];

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->config = $this
            ->collect($this->app->make('config')->get('disable-comments', []))
            ->map(fn ($value): Collection => $this->collect($value));

        add_action('init', fn () => $this->bootModules(), 99);
    }

    public function bootModules(): void
    {
        $this->collect($this->modules)->each(fn (string $module) => $module::make($this->app, $this->config));
    }

    public static function make(Application $app): self
    {
        return new static($app);
    }
}
