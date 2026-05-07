<?php

declare(strict_types=1);

namespace BrewAndBytes\AcornDisableComments\Modules;

class FrontEndModule extends AbstractModule
{
    public function handle(): void
    {
        if (! $this->enabled()) {
            return;
        }

        if ($this->config->get('comments-template', true)) {
            $this->filter('comments_template', 'replaceCommentsTemplate', 100);
        }

        if ($this->config->get('comments-link', true)) {
            add_filter('get_comments_link', '__return_empty_string');
        }

        if ($this->config->get('dequeue-reply-script', true)) {
            $this->action('wp_enqueue_scripts', 'dequeueCommentReply', 100);
        }
    }

    public function replaceCommentsTemplate(string $template): string
    {
        return dirname(__DIR__, 2).'/resources/views/comments-blank.php';
    }

    public function dequeueCommentReply(): void
    {
        wp_dequeue_script('comment-reply');
        wp_deregister_script('comment-reply');
    }
}
