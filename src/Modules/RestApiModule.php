<?php

declare(strict_types=1);

namespace BrewAndBytes\AcornDisableComments\Modules;

use WP_Error;

class RestApiModule extends AbstractModule
{
    public function handle(): void
    {
        if (! $this->enabled()) {
            return;
        }

        $this
            ->filter('rest_endpoints', 'removeCommentRoutes')
            ->filter('rest_pre_insert_comment', 'rejectCommentCreation');
    }

    /**
     * @param  array<string, mixed>  $endpoints
     * @return array<string, mixed>
     */
    public function removeCommentRoutes(array $endpoints): array
    {
        foreach (array_keys($endpoints) as $route) {
            if (str_starts_with((string) $route, '/wp/v2/comments')) {
                unset($endpoints[$route]);
            }
        }

        return $endpoints;
    }

    public function rejectCommentCreation(mixed $prepared): WP_Error
    {
        return new WP_Error(
            'comments_disabled',
            __('Comments are disabled on this site.', 'acorn-disable-comments'),
            ['status' => 403]
        );
    }
}
