<?php

namespace LongReadPlugin;

class Options implements \Dxw\Iguana\Registerable
{
    public function register() : void
    {
        add_action('acf/init', [$this, 'addOptionsPage']);
    }

    public function addOptionsPage() : void
    {
        if (function_exists('acf_add_options_page')) {
            acf_add_options_page([
                'page_title' 	=> 'Long Read Settings',
                'menu_title'	=> 'Long Read Settings',
                'menu_slug' 	=> 'long-read-settings',
                'capability'	=> 'edit_posts',
                'parent_slug' => 'options-general.php'
            ]);
        }
    }
}
