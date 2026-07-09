<?php

namespace LongReadPlugin;

class PageBreakChapterNavigation implements ChapterNavigationInterface
{
	public function getItems(): array
	{
		$chapterNavigationItems = [];
		$chapterNavigationItems[] = new ChapterNavigationItem(
			apply_filters('long_read_plugin_chapter_title', 'Chapter 1'),
			apply_filters('long_read_plugin_chapter_url', '/chapter-1')
		);
		return $chapterNavigationItems;
	}
}