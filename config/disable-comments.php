<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Close Comments
    |--------------------------------------------------------------------------
    |
    | Closes comments and pingbacks for all (or selected) post types so no new
    | comments can be submitted, regardless of per-post settings.
    |
    */

    'close-comments' => [
        'enabled' => true,

        /**
         * Post types to close comments on. Set to null to apply globally
         * via the comments_open / pings_open filters.
         */
        'post-types' => null,
    ],

    /*
    |--------------------------------------------------------------------------
    | Hide Existing Comments
    |--------------------------------------------------------------------------
    |
    | Returns an empty comment array and zero counts so any comments already
    | in the database are not surfaced on the front-end.
    |
    */

    'hide-existing-comments' => [
        'enabled' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin UI
    |--------------------------------------------------------------------------
    |
    | Strips comments-related interface from wp-admin: top-level menu, admin
    | bar node, dashboard "Recent Comments" widget, list-table columns, and
    | the Settings → Discussion submenu. Direct visits are redirected.
    |
    */

    'admin-ui' => [
        'enabled' => true,
        'menu' => true,
        'admin-bar' => true,
        'dashboard-widget' => true,
        'list-table-columns' => true,
        'discussion-settings' => true,
        'redirect-direct-visits' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Front End
    |--------------------------------------------------------------------------
    |
    | Replaces the comments template with an empty file, blanks out comment
    | links, and dequeues the comment-reply script.
    |
    */

    'front-end' => [
        'enabled' => true,
        'comments-template' => true,
        'comments-link' => true,
        'dequeue-reply-script' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | REST API
    |--------------------------------------------------------------------------
    |
    | Removes the /wp/v2/comments routes from the REST API and rejects any
    | comment-creation requests.
    |
    */

    'rest-api' => [
        'enabled' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Feeds
    |--------------------------------------------------------------------------
    |
    | Disables the global comments feed and per-post comment feeds, and stops
    | comment-feed <link> tags from being rendered in <head>.
    |
    */

    'feeds' => [
        'enabled' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | XML-RPC
    |--------------------------------------------------------------------------
    |
    | Removes the X-Pingback header, pingback methods, and comment-related
    | XML-RPC endpoints. Optionally disables XML-RPC entirely — leave that
    | sub-flag off if you need XML-RPC for application passwords or the
    | mobile app.
    |
    */

    'xml-rpc' => [
        'enabled' => true,
        'pingback-header' => true,
        'pingback-methods' => true,
        'comment-methods' => true,
        'disable-fully' => false,
    ],

];
