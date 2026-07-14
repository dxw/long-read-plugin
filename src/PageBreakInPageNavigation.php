<?php

namespace LongReadPlugin;

class PageBreakInPageNavigation implements InPageNavigationInterface
{
	/** @var array<InPageNavigationItem> */
	private $inPageNavItems = [];

	private function findHeadingMarkup(string $markup): void
	{
		$matches = [];
		preg_match_all('~<h2[^>]*>.*?</h2>~is', $markup, $matches);
		foreach ($matches[0] as $headingHtml) {
			if (empty(trim(strip_tags($headingHtml)))) {
				continue;
			}
			$this->inPageNavItems[] = $this->parseHeading($headingHtml);
		}
	}

	private function getCurrentPageMarkup(): string
	{
		global $post;
		$currentPage = max(1, (int) get_query_var('page', 1));
		$fullContent = $post->post_content ?? '';
		$pages = explode('<!--nextpage-->', $fullContent);
		return $pages[$currentPage - 1] ?? '';
	}

	private function parseHeading(string $html): InPageNavigationItem
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

	private function findHeadingBlocks(array $blocks): bool
	{
		$foundHeadings = false;
		foreach ($blocks as $block) {
			if ($block['blockName'] == 'core/heading'  && array_key_exists('attrs', $block) && (!isset($block['attrs']['level']) || $block['attrs']['level'] == 2)) {
				if (empty(trim(strip_tags($block['innerHTML'])))) {
					continue;
				}
				$this->inPageNavItems[] = $this->parseHeading($block["innerHTML"]);
				$foundHeadings = true;
			} elseif ($block['blockName'] == 'acf/group-block' || $block['blockName'] == 'core/group') {
				$foundHeadings = $this->findHeadingBlocks($block['innerBlocks']) || $foundHeadings;
			}
		}

		return $foundHeadings;
	}

	public function getItems(): array
	{
		
		$this->inPageNavItems = [];
		$currentPageMarkup = $this->getCurrentPageMarkup();
		$blocks = parse_blocks($currentPageMarkup);
		if (!$this->findHeadingBlocks($blocks)) {
			$this->findHeadingMarkup($currentPageMarkup);
		}
		return $this->inPageNavItems;
	}
}
