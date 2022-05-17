<?php

namespace LongReadPlugin;

class HeadingAnchors implements \Dxw\Iguana\Registerable
{
    public function register() : void
    {
        add_filter('block_editor_settings_all', [$this, 'enforceAnchors']);
    }

    public function enforceAnchors(array $settings) : array
    {
        $settings['__experimentalGenerateAnchors'] = true;
        return $settings;
    }
}
