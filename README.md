# Long Read Plugin

This plugin provides the basic functionality for adding "long read" items (i.e. multi-page documents divided into "chapters", with in-chapter and between-chapter navigation) to a WordPress site.

A single "long read" is composed of a parent long read post, and it's direct children. The parent post will function as the first chapter of the long read, and its children as the subsequent chapters.

## What this plugin does

1. Adds the "long read" post type
1. Enforces the block editor for that post type (even if the classic editor plugin is activated)
1. Provides access to a static method that returns the data required to build the long read navigation. In-chapter navigation is based on the `h2`s used within a single long read post, between-chapter navigation is based on parrent/sibling relationships. The plugin enforces the auto-generation of IDs attached to heading blocks to help with this.
1. Provides a basic long read template, compatible with the [dxw gov.uk theme](https://github.com/dxw/govuk-theme). This is mainly intended to be used as an example of how you might build your own long read template within your own custom theme.

## How to use this plugin

Recommended plugin to run alongside this:

- [Nested Pages](https://en-gb.wordpress.org/plugins/wp-nested-pages/). Long read chapters are ordered according to the WordPress "menu order". This plugin allows you to set that via clicking & dragging in the admin post listing, rather than having to manually set the menu order on each individual long read post.

1. Install this plugin (ideally via [Whippet](https://github.com/dxw/whippet)), and activate it
1. Add a `single-long-read.php` template to your site's theme. This will display all long read content.
1. Within that template, call `LongReadPlugin\Navigation::getItems()` to return the data required to build the navigation. See this repo's [example template](/template/single-long-read.php) for how to use the data returned. The method returns an array of objects, structured as follows:
    ```php
    [
        (object) [
            'title' => 'The parent long read post'
            'url' => 'http://url-of-parent-long-read-post'
        ],
        (object) [
            'title' => 'The first direct child of the parent long read post, by menu order'
            'url' => 'http://url-of-first-direct-child'
        ],
        (object) [
            'title' => 'The second direct child of the parent long read post, by menu order'
            'url' => 'http://url-of-second-direct-child'
        ],
        (object) [
            'title' => 'The third direct child, and currently viewed post',
            'url' => null //The post currently being viewed will always have a null url
            'subItems' => [
                // An array of the h2s within the currently viewed post
                (object) [
                    'title' => 'First heading 2'
                    'id' => 'id-of-first-h2',
                ],
                (object) [
                    'title' => 'Second heading 2'
                    'id' => 'id-of-second-h2',
                ],
                ...
            ]
        ],
        (object) []
            'title' => 'The fourth direct child of the parent long read post, by menu order'
            'url' => 'http://url-of-fourth-direct-child'
        ],
        ...
    ]
    ```
1. Style your long read template as required.

## PHP version

This plugin builds on PHP 8.2 and deploys on PHP 8.3.

## Development

Install the dependencies:

```
composer install
```

Run the tests:
```
vendor/bin/kahlan spec
```

Run the linters:
```
vendor/bin/psalm
vendor/bin/php-cs-fixer fix
```

## CHANGELOG and versioning

Please update the CHANGELOG as you develop, and publish and tag new releases.

As well as the individual version tags, we also have a major version tag (currently v1) that tracks the latest release for that major version. That has to be manually updated after you've done the release on GitHub as follows:

(e.g. if you'd just published v1.6.0):

```sh
git checkout main
git fetch --tags -f
git tag -f v1 v1.6.0
git push origin -f --tags
```
