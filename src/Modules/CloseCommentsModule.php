<?php

declare(strict_types=1);

namespace BrewAndBytes\AcornDisableComments\Modules;

class CloseCommentsModule extends AbstractModule
{
    public function handle(): void
    {
        if (! $this->enabled()) {
            return;
        }

        $postTypes = $this->config->get('post-types');

        if (is_array($postTypes) && $postTypes !== []) {
            $this->filter('comments_open', 'closeForPostType', 10, 2);
            $this->filter('pings_open', 'closeForPostType', 10, 2);

            return;
        }

        $this
            ->disable('comments_open')
            ->disable('pings_open')
            ->disable('post_pingback_enabled');
    }

    public function closeForPostType(bool $open, int $postId): bool
    {
        $postTypes = (array) $this->config->get('post-types', []);

        return in_array(get_post_type($postId), $postTypes, true) ? false : $open;
    }
}
