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
        /* In WordPress pre-v6, this was an experimental setting */
        $settings['__experimentalGenerateAnchors'] = true;
        /* From v6 onwards, it's a standard setting */
        $settings['generateAnchors'] = true;
        return $settings;
    }
}
