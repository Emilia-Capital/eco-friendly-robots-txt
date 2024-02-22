[![CS](https://github.com/jdevalk/fewer-tags-pro/actions/workflows/cs.yml/badge.svg)](https://github.com/jdevalk/fewer-tags-pro/actions/workflows/cs.yml)
[![Lint PHP](https://github.com/Emilia-Capital/fewer-tags-pro/actions/workflows/lint-php.yml/badge.svg)](https://github.com/Emilia-Capital/fewer-tags-pro/actions/workflows/lint-php.yml)

# Eco-Friendly Robots.txt
Optimizes your site's robots.txt to reduce server load and CO2 footprint by blocking unnecessary crawlers while allowing major search engines and specific tools.

[Test this plugin on the WordPress playground](https://playground.wordpress.net/#%7B%22landingPage%22:%22/wp-admin/edit-tags.php?taxonomy=post_tag%22,%22features%22:%7B%22networking%22:true%7D,%22steps%22:%5B%7B%22step%22:%22defineWpConfigConsts%22,%22consts%22:%7B%22IS_PLAYGROUND_PREVIEW%22:true%7D%7D,%7B%22step%22:%22login%22,%22username%22:%22admin%22,%22password%22:%22password%22%7D,%7B%22step%22:%22installPlugin%22,%22pluginZipFile%22:%7B%22resource%22:%22url%22,%22url%22:%22https://bypass-cors.altha.workers.dev/https://github.com/Emilia-Capital/eco-friendly-robots-txt/archive/refs/heads/main.zip%22%7D,%22options%22:%7B%22activate%22:true%7D%7D%5D%7D)

## Development

If you're developing on this plugin, you will probably want to run tests and lint. You can do that by running the following commands:

* PHP Code style: `composer check-cs`
* PHP Autofixer for code style: `composer fix-cs`
* PHP Lint: `composer lint`
* PHP Unit tests: `composer test`

## Releasing an update

When releasing an update, the following steps should be done:
1. Update the `Version: ` header in the main plugin file.
2. [Create a new release on GitHub](https://github.com/Emilia-Capital/fewer-tags-pro/releases/new) with the same version number as the `Version: ` header.
3. [Edit the download](https://fewertags.com/wp-admin/post.php?post=3330&action=edit) on fewertags.com, and in the *Download Files* section, select the version tag from the dropdown.
