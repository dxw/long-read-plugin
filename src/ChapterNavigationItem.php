<?php

namespace LongReadPlugin;

class ChapterNavigationItem
{
	public readonly string $title;
	public readonly ?string $url;

	public function __construct(string $title, ?string $url)
	{
		$this->title = $title;
		$this->url = $url;
	}
}
