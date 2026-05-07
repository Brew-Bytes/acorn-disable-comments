# Acorn Disable Comments

A theme-agnostic [Acorn](https://roots.io/acorn/) package that fully disables
WordPress comments. Drop it into any [Sage](https://roots.io/sage/) theme
(or any Acorn-aware project) and stop re-implementing the same dozen comment-
disabling hooks on every build.

Modeled on [`roots/acorn-prettify`](https://github.com/roots/acorn-prettify):
each concern lives in its own module, every module is independently
toggleable from `config/disable-comments.php`.

## What it disables

| Module | What it does |
| --- | --- |
| `close-comments` | Closes comments and pingbacks on every post type. |
| `hide-existing-comments` | Returns an empty comment array; reports zero comments. |
| `admin-ui` | Removes the Comments admin menu, admin-bar item, dashboard widget, list-table columns, and the Discussion settings page. Redirects direct visits. |
| `front-end` | Short-circuits `comments_template`, empties comment links, dequeues `comment-reply.js`. |
| `rest-api` | Strips `/wp/v2/comments` routes and rejects comment writes. |
| `feeds` | Disables the global comments feed and per-post comment feeds. |
| `xml-rpc` | Removes the `X-Pingback` header and pingback / comment XML-RPC methods. |

## Installation

```bash
composer require brew-bytes/acorn-disable-comments
```

The provider auto-registers via `extra.acorn.providers`. No further wiring
needed — defaults disable everything.

### Customizing

Publish the config to your app:

```bash
wp acorn vendor:publish --tag=disable-comments-config
```

Then edit `config/disable-comments.php` to toggle individual modules or
sub-features:

```php
return [
    'close-comments' => ['enabled' => true],
    'xml-rpc' => [
        'enabled' => true,
        'disable-fully' => false, // keep XML-RPC available for app passwords
    ],
    // ...
];
```

Setting any module's `enabled` to `false` removes its hooks entirely.

## Requirements

- PHP 8.1+
- Acorn 4.x or 5.x
- WordPress 6.0+

## License

MIT &copy; Brew & Bytes
