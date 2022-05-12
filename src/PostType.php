<?php

namespace LongReadPlugin;

class PostType implements \Dxw\Iguana\Registerable
{
    public function register() : void
    {
        add_action('init', [$this, 'registerPostType']);
    }

    public function registerPostType() : void
    {
        register_post_type('long-read', [
            'label' => 'Long Reads',
            'labels' => [
                'singular_name' => 'Long Read',
                'add_new_item' => 'Add New Long Read',
                'edit_item' => 'Edit Long Read',
                'new_item' => 'New Long Read',
                'view_item' => 'View Long Read',
                'view_items' => 'View Long Reads'
            ],
            'public' => true,
            'hierarchical' => true,
            'show_in_rest' => true,
            'menu_icon' => 'dashicons-feedback',
            'supports' => [
                'revisions',
                'page-attributes',
                'editor',
                'title'
            ]
        ]);
    }
}
