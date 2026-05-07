<?php

declare(strict_types=1);

namespace BrewAndBytes\AcornDisableComments\Modules;

use BrewAndBytes\AcornDisableComments\Contracts\Module;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Roots\Acorn\Application;

/**
 * @phpstan-consistent-constructor
 */
abstract class AbstractModule implements Module
{
    protected Application $app;

    protected Collection $config;

    public function __construct(Application $app, Collection $config)
    {
        $this->app = $app;
        $this->config = Collection::make($config->get($this->getKey(), []));

        $this->boot();
    }

    public static function make(Application $app, Collection $config): self
    {
        return new static($app, $config);
    }

    protected function boot(): void
    {
        if ($this->config->isEmpty()) {
            return;
        }

        $method = method_exists($this, 'handle') ? 'handle' : '__invoke';

        $this->app->call([$this, $method]);
    }

    protected function enabled(): bool
    {
        return (bool) $this->config->get('enabled', false);
    }

    protected function getKey(): string
    {
        return (string) Str::of(static::class)
            ->afterLast('\\')
            ->beforeLast('Module')
            ->snake('-');
    }

    protected function filter(string $hook, string $method, int $priority = 10, int $args = 1): self
    {
        add_filter($hook, [$this, $method], $priority, $args);

        return $this;
    }

    protected function filters(array $hooks, string $method, int $priority = 10, int $args = 1): self
    {
        foreach ($hooks as $hook) {
            $this->filter($hook, $method, $priority, $args);
        }

        return $this;
    }

    protected function action(string $hook, string $method, int $priority = 10, int $args = 1): self
    {
        add_action($hook, [$this, $method], $priority, $args);

        return $this;
    }

    protected function actions(array $hooks, string $method, int $priority = 10, int $args = 1): self
    {
        foreach ($hooks as $hook) {
            $this->action($hook, $method, $priority, $args);
        }

        return $this;
    }

    protected function disable(string $hook, int $priority = 10): self
    {
        add_filter($hook, '__return_false', $priority);

        return $this;
    }

    protected function disableAll(array $hooks, int $priority = 10): self
    {
        foreach ($hooks as $hook) {
            $this->disable($hook, $priority);
        }

        return $this;
    }

    protected function zeroOut(string $hook, int $priority = 10): self
    {
        add_filter($hook, '__return_zero', $priority);

        return $this;
    }

    protected function emptyArray(string $hook, int $priority = 10): self
    {
        add_filter($hook, '__return_empty_array', $priority);

        return $this;
    }
}
