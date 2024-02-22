[![CS](https://github.com/jdevalk/fewer-tags-pro/actions/workflows/cs.yml/badge.svg)](https://github.com/jdevalk/fewer-tags-pro/actions/workflows/cs.yml)
[![Lint PHP](https://github.com/Emilia-Capital/fewer-tags-pro/actions/workflows/lint-php.yml/badge.svg)](https://github.com/Emilia-Capital/fewer-tags-pro/actions/workflows/lint-php.yml)

# Eco-Friendly Robots.txt
Optimizes your site's robots.txt to reduce server load and CO2 footprint by blocking unnecessary crawlers while allowing major search engines and specific tools.

[Test this plugin on the WordPress playground](https://playground.wordpress.net/#%7B%22landingPage%22:%22/?robots=1%22,%22features%22:%7B%22networking%22:true%7D,%22steps%22:%5B%7B%22step%22:%22defineWpConfigConsts%22,%22consts%22:%7B%22IS_PLAYGROUND_PREVIEW%22:true%7D%7D,%7B%22step%22:%22login%22,%22username%22:%22admin%22,%22password%22:%22password%22%7D,%7B%22step%22:%22installPlugin%22,%22pluginZipFile%22:%7B%22resource%22:%22url%22,%22url%22:%22https://bypass-cors.altha.workers.dev/https://github.com/Emilia-Capital/eco-friendly-robots-txt/archive/refs/heads/main.zip%22%7D,%22options%22:%7B%22activate%22:true%7D%7D%5D%7D)

## Installation

* Download the plugin [right here](https://github.com/Emilia-Capital/eco-friendly-robots-txt/archive/refs/heads/main.zip) and install it.

> [!WARNING]  
> The plugin _will_ delete your existing `robots.txt` file, if one exists on your server, although it'll try to back it up. It'll restore it, when it can, when you uninstall the plugin.

## Default output

The default output of this plugin is as follows:

```txt
# This site is very specific about who it allows crawling from.
# Our default is to not allow crawling:
User-agent: *
Disallow: /

# Below are the crawlers that are allowed to crawl this site.
# Below that list, you'll find paths that are blocked, even for them,
# and then paths within those blocked paths that are allowed.
User-agent: Applebot
User-agent: ia_archiver
User-agent: Baiduspider
User-agent: Bingbot
User-agent: DuckDuckBot
User-agent: Googlebot
User-agent: AdsBot-Google
User-agent: MediaPartners-Google
User-agent: Yandex
User-agent: Slurp
User-agent: FacebookExternalHit
User-agent: LinkedInBot
User-agent: WhatsApp
User-agent: Twitterbot
Allow: /
Disallow: /wp-json/
Disallow: /?rest_route=
Disallow: /wp-admin/
Disallow: /wp-content/cache/
Disallow: /wp-content/plugins/
Disallow: /xmlrpc.php
Disallow: /wp-includes/
Allow: /wp-includes/css/
Allow: /wp-includes/js/

# XML Sitemap:
Sitemap: https://example.com/sitemap_index.xml
```

## Filters

The plugin exposes the following filters:

* `emilia/ecofriendly_robots/allowed_spiders` - filter an `array` of user agents.
* `emilia/ecofriendly_robots/blocked_paths` - filters an `array` of blocked paths.
* `emilia/ecofriendly_robots/allowed_paths` - filters an `array` of allowed paths, should be subsets of `blocked_paths`.
* `emilia/ecofriendly_robots/output` - filters the entire output as a `string`.

## Development

If you're developing on this plugin, you will probably want to run tests and lint. You can do that by running the following commands:

* PHP Code style: `composer check-cs`
* PHP Autofixer for code style: `composer fix-cs`
* PHP Lint: `composer lint`
* PHP Unit tests: `composer test`
