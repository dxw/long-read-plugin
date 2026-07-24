<?php

namespace LongReadPlugin;

class PageBreakInPageNavigation implements InPageNavigationInterface
{
	private HeadingBlockParser $headingBlockParser;

	public function __construct(?HeadingBlockParser $headingBlockParser = null)
	{
		$this->headingBlockParser = $headingBlockParser ?? new HeadingBlockParser();
	}

	/** @return InPageNavigationItem[] */
	private function findHeadingMarkup(string $markup): array
	{
		$items = [];
		$matches = [];
		preg_match_all('~<h2[^>]*>.*?</h2>~is', $markup, $matches);
		foreach ($matches[0] as $headingHtml) {
			if (empty(trim(strip_tags($headingHtml)))) {
				continue;
			}
			$items[] = $this->headingBlockParser->parseHeading($headingHtml);
		}

		return $items;
	}

	private function getCurrentPageMarkup(): string
	{
		global $post;
		$currentPage = max(1, (int) get_query_var('page', 1));
		$fullContent = $post->post_content ?? '';
		$pages = explode('<!--nextpage-->', $fullContent);
		return $pages[$currentPage - 1] ?? '';
	}

	public function getItems(): array
	{
		$currentPageMarkup = $this->getCurrentPageMarkup();
		$blocks = parse_blocks($currentPageMarkup);
		$items = $this->headingBlockParser->collectHeadingItems($blocks);
		if (count($items) > 0) {
			return $items;
		}

		return $this->findHeadingMarkup($currentPageMarkup);
	}
}
