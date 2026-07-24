<?php

namespace LongReadPlugin;

class HeadingBlockParser
{
	public function parseHeading(string $html): InPageNavigationItem
	{
		$matches = [];
		$id = null;
		if (preg_match('/(id=")(.*?)"/', $html, $matches)) {
			$id = $matches[2] ?? null;
		}

		return new InPageNavigationItem(
			trim(strip_tags($html)),
			$id
		);
	}

	/** @return InPageNavigationItem[] */
	public function collectHeadingItems(array $blocks): array
	{
		$items = [];
		foreach ($blocks as $block) {
			if ($this->isLevelTwoHeading($block)) {
				$item = $this->extractHeadingItem($block);
				if ($item !== null) {
					$items[] = $item;
				}
				continue;
			}

			if ($this->isGroupBlock($block)) {
				$innerBlocks = $block['innerBlocks'] ?? [];
				$items = array_merge($items, $this->collectHeadingItems($innerBlocks));
			}
		}

		return $items;
	}

	private function isLevelTwoHeading(array $block): bool
	{
		if (($block['blockName'] ?? null) !== 'core/heading' || !array_key_exists('attrs', $block)) {
			return false;
		}

		return !isset($block['attrs']['level']) || $block['attrs']['level'] == 2;
	}

	private function isGroupBlock(array $block): bool
	{
		return ($block['blockName'] ?? null) === 'acf/group-block'
			|| ($block['blockName'] ?? null) === 'core/group';
	}

	private function extractHeadingItem(array $block): ?InPageNavigationItem
	{
		$innerHtml = $block['innerHTML'] ?? '';
		if (empty(trim(strip_tags($innerHtml)))) {
			return null;
		}

		return $this->parseHeading($innerHtml);
	}
}
