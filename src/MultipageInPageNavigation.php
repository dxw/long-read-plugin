<?php

namespace LongReadPlugin;

class MultipageInPageNavigation implements InPageNavigationInterface
{
	private HeadingBlockParser $headingBlockParser;

	public function __construct(?HeadingBlockParser $headingBlockParser = null)
	{
		$this->headingBlockParser = $headingBlockParser ?? new HeadingBlockParser();
	}

	public function getItems(): array
	{
		global $post;
		$blocks = parse_blocks($post->post_content);
		return $this->headingBlockParser->collectHeadingItems($blocks);
	}
}
