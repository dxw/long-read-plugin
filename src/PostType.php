<?php

namespace LongReadPlugin;

class PostType implements \Dxw\Iguana\Registerable
{
    public function register() : void
    {
        add_action('init', [$this, 'registerPostType']);
        // The value for this filter we want to override is applied with priority 100
        // So we use priority 1000 to override
        add_filter('use_block_editor_for_post_type', [$this, 'enforceBlockEditor'], 1000, 2);
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

    public function enforceBlockEditor(bool $useBlockEditor, string $postType) : bool
    {
        if ($postType === 'long-read') {
            return true;
        }
        return $useBlockEditor;
    }
}
