<?php

namespace LongReadPlugin;

class InPageNavigation
{
    public function getItems() : array
    {
        $inPageNavItems = [];
        global $post;
        $blocks = parse_blocks($post->post_content);
        foreach ($blocks as $block) {
            if ($block['blockName'] == 'core/heading' && array_key_exists('attrs', $block) && (!isset($block['attrs']['level']) || $block['attrs']['level'] == 2)) {
                $matches = [];
                preg_match('/(id=")(.*)"/', $block['innerHTML'], $matches);
                $inPageNavItems[] = (object) [
                    'title' => trim(strip_tags($block["innerHTML"])),
                    'id' => $matches[2]
                ];
            }
        }
        return $inPageNavItems;
    }
}
