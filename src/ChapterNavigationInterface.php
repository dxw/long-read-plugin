<?php

namespace LongReadPlugin;

/** @api */
interface ChapterNavigationInterface
{
	/** @return ChapterNavigationItem[] */
	public function getItems(): array;
}
