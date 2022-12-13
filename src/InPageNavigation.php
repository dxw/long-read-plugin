<?php

namespace LongReadPlugin;

class InPageNavigation
{

    /** @var array $inPageNavItems */
    private $inPageNavItems = [];

    private function parseHeading(string $html): \stdClass
    {
        $matches = [];
        preg_match('/(id=")(.*?)"/', $html, $matches);
        return (object) [
            'title' => trim(strip_tags($html)),
            'id' => $matches[2]
        ];
    }

    private function findHeadingBlocks(array $blocks): void
    {
        foreach ($blocks as $block) {
            if ($block['blockName'] == 'core/heading'  && array_key_exists('attrs', $block) && (!isset($block['attrs']['level']) || $block['attrs']['level'] == 2)) {
                $this->inPageNavItems[] = $this->parseHeading($block["innerHTML"]);
            } elseif ($block['blockName'] == 'acf/group-block' || $block['blockName'] == 'core/group') {
                $this->findHeadingBlocks($block['innerBlocks']);
            }
        }
    }

    public function getItems() : array
    {
        global $post;
        $blocks = parse_blocks($post->post_content);
        $this->findHeadingBlocks($blocks);
        return $this->inPageNavItems;
    }
}
