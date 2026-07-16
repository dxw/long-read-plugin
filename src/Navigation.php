<?php

namespace LongReadPlugin;

class Navigation
{
	private static ChapterNavigationInterface $chapterNavigation;
	private static InPageNavigationInterface $inPageNavigation;

	public function __construct(ChapterNavigationInterface $chapterNavigation, InPageNavigationInterface $inPageNavigation)
	{
		static::$chapterNavigation = $chapterNavigation;
		static::$inPageNavigation = $inPageNavigation;
	}

	public static function getItems(): array
	{
		if (!isset(static::$chapterNavigation) || !isset(static::$inPageNavigation)) {
			return [];
		}
		$chapterNavItems = static::$chapterNavigation->getItems();
		$inPageNavItems = static::$inPageNavigation->getItems();

		foreach ($chapterNavItems as $chapterNavItem) {
			if ($chapterNavItem->url === null) {
				$chapterNavItem->subItems = $inPageNavItems;
				// Don't include in-page nav items where the heading we found is actually the chapter title
				if (array_key_exists(0, $chapterNavItem->subItems) && $chapterNavItem->subItems[0]->title === $chapterNavItem->title) {
					unset($chapterNavItem->subItems[0]);
				}
			}
		}
		return $chapterNavItems;
	}
}
