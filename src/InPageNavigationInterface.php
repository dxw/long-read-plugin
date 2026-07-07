<?php

namespace LongReadPlugin;

interface InPageNavigationInterface
{
	/** @return InPageNavigationItem[] */
	public function getItems(): array;
}
