<?php

namespace LongReadPlugin;

class HierarchicalInPageNavigation implements InPageNavigationInterface
{
	/** @var array $inPageNavItems */
	private $inPageNavItems = [];

	private function parseHeading(string $html): InPageNavigationItem
	{
		$matches = [];
		preg_match('/(id=")(.*?)"/', $html, $matches);
		return new InPageNavigationItem(
			trim(strip_tags($html)),
			$matches[2]
		);
	}

	private function findHeadingBlocks(array $blocks): void
	{
		foreach ($blocks as $block) {
			if ($block['blockName'] == 'core/heading'  && array_key_exists('attrs', $block) && (!isset($block['attrs']['level']) || $block['attrs']['level'] == 2)) {
				if (empty(trim(strip_tags($block['innerHTML'])))) {
					continue;
				}
				$this->inPageNavItems[] = $this->parseHeading($block["innerHTML"]);
			} elseif ($block['blockName'] == 'acf/group-block' || $block['blockName'] == 'core/group') {
				$this->findHeadingBlocks($block['innerBlocks']);
			}
		}
	}

	public function getItems(): array
	{
		global $post;
		$blocks = parse_blocks($post->post_content);
		$this->findHeadingBlocks($blocks);
		return $this->inPageNavItems;
	}
}
