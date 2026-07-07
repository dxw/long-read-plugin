<?php

namespace LongReadPlugin;

interface ChapterNavigationInterface
{
	/** @return ChapterNavigationItem[] */
	public function getItems(): array;
}
