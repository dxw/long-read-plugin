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
			}
		}
		return $chapterNavItems;
	}
}
