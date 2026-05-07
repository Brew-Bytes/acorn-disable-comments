<?php

declare(strict_types=1);

namespace BrewAndBytes\AcornDisableComments\Modules;

class FeedsModule extends AbstractModule
{
    public function handle(): void
    {
        if (! $this->enabled()) {
            return;
        }

        $this->disable('feed_links_show_comments_feed');

        add_filter('post_comments_feed_link', '__return_empty_string');

        $this->action('template_redirect', 'redirectCommentFeeds', 1);
    }

    public function redirectCommentFeeds(): void
    {
        if (! is_comment_feed()) {
            return;
        }

        wp_safe_redirect(home_url('/'), 302);
        exit;
    }
}
