<?php

declare(strict_types=1);

namespace BrewAndBytes\AcornDisableComments\Modules;

class XmlRpcModule extends AbstractModule
{
    public function handle(): void
    {
        if (! $this->enabled()) {
            return;
        }

        if ($this->config->get('disable-fully', false)) {
            $this->disable('xmlrpc_enabled');
        }

        if ($this->config->get('pingback-header', true)) {
            $this->filter('wp_headers', 'removePingbackHeader');
        }

        if ($this->config->get('pingback-methods', true) || $this->config->get('comment-methods', true)) {
            $this->filter('xmlrpc_methods', 'removeCommentRelatedMethods');
        }
    }

    /**
     * @param  array<string, string>  $headers
     * @return array<string, string>
     */
    public function removePingbackHeader(array $headers): array
    {
        unset($headers['X-Pingback']);

        return $headers;
    }

    /**
     * @param  array<string, callable|string>  $methods
     * @return array<string, callable|string>
     */
    public function removeCommentRelatedMethods(array $methods): array
    {
        if ($this->config->get('pingback-methods', true)) {
            foreach (self::PINGBACK_METHODS as $name) {
                unset($methods[$name]);
            }
        }

        if ($this->config->get('comment-methods', true)) {
            foreach (self::COMMENT_METHODS as $name) {
                unset($methods[$name]);
            }
        }

        return $methods;
    }

    /**
     * @var list<string>
     */
    private const PINGBACK_METHODS = [
        'pingback.ping',
        'pingback.extensions.getPingbacks',
    ];

    /**
     * @var list<string>
     */
    private const COMMENT_METHODS = [
        'wp.newComment',
        'wp.editComment',
        'wp.deleteComment',
        'wp.getComment',
        'wp.getComments',
        'wp.getCommentCount',
        'wp.getCommentStatusList',
    ];
}
